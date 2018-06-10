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

  # EmployerName  DepartmentOrSubdivision Position  OtherPositions  MinPositionSalary MaxPositionSalary ReportedBaseWage  RegularPay  OvertimePay LumpSumPay  OtherPay  TotalWages  DefinedBenefitPlanContribution  EmployeesRetirementCostCovered  DeferredCompensationPlan  HealthDentalVision  TotalRetirementAndHealthContribution  PensionFormula
  # Columns 0, 2, 7, 8, 9, 10, 11, 15
  with open('gcc-2016_CommunityCollegeDistrict.txt', encoding = 'ISO-8859-1') as data_file:
    for data_line in data_file:
        cols = data_line.split('\t')
        db.execute("INSERT INTO Employee (EmployerName, Position, RegularPay, OvertimePay, LumpSumPay, OtherPay, TotalWages, HealthDentalVision) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [cols[i] for i in (0, 2, 7, 8, 9, 10, 11, 15)])
