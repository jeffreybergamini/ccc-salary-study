import collections
import csv
import difflib
import itertools
import os

cabrillo_pt = dict()
other_pt = collections.defaultdict(list)

with open('cabrillo-college-2016.csv') as cabrillo_csv:
  for csv_line in csv.reader(cabrillo_csv):
    if csv_line[1] == 'Adjunct Instructor':
      cabrillo_pt[tuple(token for token in csv_line[0].lower().split() if len(token) > 1)] = csv_line

for root, dirs, files in os.walk('.'):
  for csv_filename in files:
    if csv_filename.endswith(".csv") and not csv_filename.startswith('cabrillo'):
      with open(csv_filename) as csv_file:
        for csv_line in csv.reader(csv_file):
          for name_order in itertools.permutations(token for token in  csv_line[0].lower().split() if len(token) > 1):
            if name_order in cabrillo_pt:
              other_pt[name_order].append(csv_line)

with open('cabrillo-freeway-flyers-fuzzy-match.csv', 'w') as out_csvfile:
  out_csv = csv.writer(out_csvfile)
  out_csv.writerow('Employee Name,Job Title,Base Pay,Overtime Pay,Other Pay,Benefits,Total Pay,Total Pay & Benefits,Year,Notes,Agency,Status'.split(','))
  for cabrillo_name in cabrillo_pt:
    cabrillo_row = cabrillo_pt[cabrillo_name]
    if cabrillo_name in other_pt:
      out_csv.writerow(cabrillo_row)
      for other_row in other_pt[cabrillo_name]:
        other_row[0] = cabrillo_row[0]
        out_csv.writerow(other_row)
