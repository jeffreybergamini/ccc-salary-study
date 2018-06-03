#!/usr/bin/env python3
import csv
import difflib
import math
import numpy
import re
import sqlite3
import sys

''' BEGIN CONSTANTS '''
INTEREST_RATE = .045
''' END CONSTANTS '''

def distance_km(lat1, lon1, lat2, lon2):
  dist_radians = 2 * math.asin(math.sqrt(pow(math.sin((lat1 - lat2) / 2), 2)
                + math.cos(lat1) * math.cos(lat2) * math.pow(math.sin((lon1 - lon2) / 2), 2)));
  dist_knots = ((180 * 60) / math.pi) * dist_radians;
  return dist_knots * 1852 / 1000;

zips = dict()
zips_done = set()
cft_district_names = set()

with sqlite3.connect('salary-data.sqlite') as conn:
  db = conn.cursor()

  # DB:  ft_salary (district TEXT, ma_plus INTEGER, step INTEGER, salary INTEGER, hourly REAL);
  # File: district ma_plus step salary
  # Per CFT:
  #  Full-time faculty were assumed to receive 75% of their annual salary for prep & grading only (no office hours, no governance work) 30 hours/40 hours = .75
  #  17 ½ weeks x 9 units = 157.50 hours a semester
  #  Full-time hours were considered to be 40 hours (30 hours class and prep, 5 office hours, 5 governance and committees)
  #  35 weeks x 15 units (hours) = 525 hours annually
  #  To convert full-time annual salary to hourly the formula used was: (Full-time annual salary x .75)/525
  with open('cft-ft-2016-2017.txt') as ft_file:
    for ft_line in ft_file:
        tokens = ft_line.split('\t')
        district, ma_plus, step, salary = tokens[0], int(tokens[1]), int(tokens[2]), int(tokens[3])
        #hourly = salary * .75 / 525
        hourly = salary / 525
        db.execute("INSERT INTO ft_salary (district, ma_plus, step, salary, hourly) VALUES (?, ?, ?, ?, ?)", (district, ma_plus, step, salary, hourly))
        cft_district_names.add(district)

  # DB:  pt_salary (district TEXT, ma_plus INTEGER, step INTEGER, hourly REAL);
  # File: district ma_plus step salary officehradjustment (number for addition, * x for factor)
  with open('cft-pt-2016-2017.txt') as pt_file:
    for pt_line in pt_file:
        tokens = pt_line.split('\t')
        district, ma_plus, step, hourly, office = tokens[0], int(tokens[1]), int(tokens[2]), float(tokens[3]), tokens[4]
        if office[0] == '*':
            hourly *= float(office.split()[1])
        else:
            hourly += float(office)
        db.execute("INSERT INTO pt_salary (district, ma_plus, step, hourly) VALUES (?, ?, ?, ?)", (district, ma_plus, step, hourly))
        cft_district_names.add(district)
   
  # DB: CREATE TABLE district (district TEXT, zip INTEGER);
  # File: Title;Street Address;City;State;Zip;Program Category Label;Freeform Address;Community College District;Phone #;Website
  with open('ca-community-colleges.txt') as districts_file:
    for district_line in districts_file:
        tokens = district_line.split('\t')
        raw_name = tokens[7]
        zip_code = int(tokens[4])
        # Make sure we match CFT's district names
        best_match = None
        for words in (3, 2, 1):
            matches = [cft_name for cft_name in cft_district_names if re.split('[ -/.]+', cft_name.lower())[:words] == re.split('[ -/.]+', raw_name.lower())[:words]]
            if len(matches) == 1:
                best_match = matches[0]
                break
        if best_match is None:
            best_match = max((difflib.SequenceMatcher(None, raw_name, cft_name).ratio(), cft_name) for cft_name in cft_district_names)[1]
        db.execute("INSERT INTO district (district, zip) VALUES (?, ?)", (best_match, zip_code))
    
  # DB: CREATE TABLE home_value (zip INTEGER, zhvi INTEGER, qinc INTEGER);
  # File: "Date","RegionID","RegionName","State","Metro","County","City","SizeRank","Zhvi","MoM","QoQ","YoY","5Year","10Year","PeakMonth","PeakQuarter","PeakZHVI","PctFallFromPeak","LastTimeAtCurrZHVI"
  # Ref for qualifiying income: https://www.nar.realtor/research-and-statistics/housing-statistics/housing-affordability-index/methodology
  with open('Zip_Zhvi_Summary_AllHomes.csv') as zhvi_file:
    zhvi_doc = csv.reader(zhvi_file)
    for zhvi_line in zhvi_doc:
        if zhvi_line[3] == 'CA':
            zip_code = int(zhvi_line[2])
            zhvi = int(zhvi_line[8])
            pmt = abs(numpy.pmt(INTEREST_RATE / 12, 12 * 30, zhvi))
            qinc = round(pmt * 4 * 12)
            db.execute("INSERT INTO home_value (zip, zhvi, qinc) VALUES (?, ?, ?)", (zip_code, zhvi, qinc))

  # File: zip lat lon (in degrees)
  with open('zip_codes.txt') as zips_file:
    for zip_line in zips_file:
      zip_code, lat, lon = zip_line.split('\t')
      zip_code = int(zip_code)
      lat = math.radians(float(lat))
      lon = math.radians(float(lon))
      zips[zip_code] = (lat, lon)

  # DB: CREATE TABLE zip_distance (src INTEGER, dst INTEGER, distance REAL);
  for zip1 in zips:
    for zip2 in zips:
      lat1, lon1 = zips[zip1]
      lat2, lon2 = zips[zip2]
      distance = distance_km(lat1, lon1, lat2, lon2)
      if distance <= 70:
          db.execute("INSERT INTO zip_distance (src, dst, distance) VALUES (?, ?, ?)", (zip1, zip2, distance))
  db.close()

