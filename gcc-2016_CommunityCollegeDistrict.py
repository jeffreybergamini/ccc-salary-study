#!/usr/bin/env python3
import csv
import difflib
import math
import numpy
import re
import sqlite3
import sys

with sqlite3.connect('gcc-2016_CommunityCollegeDistrict.sqlite') as conn:
  db = conn.cursor()

  employer_names = set()

  # EmployerName  DepartmentOrSubdivision Position  OtherPositions  MinPositionSalary MaxPositionSalary ReportedBaseWage  RegularPay  OvertimePay LumpSumPay  OtherPay  TotalWages  DefinedBenefitPlanContribution  EmployeesRetirementCostCovered  DeferredCompensationPlan  HealthDentalVision  TotalRetirementAndHealthContribution  PensionFormula
  # Columns 0, 2, 7, 8, 9, 10, 11, 15
  with open('gcc-2016_CommunityCollegeDistrict.txt', encoding = 'ISO-8859-1') as data_file:
    for data_line in data_file:
        cols = data_line.split('\t')
        employer_names.add(cols[0])
        db.execute("INSERT INTO Employee (EmployerName, Position, RegularPay, OvertimePay, LumpSumPay, OtherPay, TotalWages, HealthDentalVision) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [cols[i] for i in (0, 2, 7, 8, 9, 10, 11, 15)])

  # DB: CREATE TABLE StudentCount (EmployerName TEXT, HeadCount INTEGER);
  # File: District;Enrollment
  with open('StudentEnrollmentStatus.txt') as enrollments_file:
    for enrollment_line in enrollments_file:
        tokens = enrollment_line.split('\t')
        raw_name = tokens[0]
        head_count = int(tokens[1])
        # Make sure we match CFT's district names
        best_match = None
        for words in (3, 2, 1):
            matches = [gcc_name for gcc_name in employer_names if re.split('[ -/.]+', gcc_name.lower())[:words] == re.split('[ -/.]+', raw_name.lower())[:words]]
            if len(matches) == 1:
                best_match = matches[0]
                break
        if best_match is None:
            best_match = max((difflib.SequenceMatcher(None, raw_name, gcc_name).ratio(), gcc_name) for gcc_name in employer_names)[1]
        db.execute("INSERT INTO StudentCount (EmployerName, HeadCount) VALUES (?, ?)", (best_match, head_count))

