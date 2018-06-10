DBFILE=gcc-2016_CommunityCollegeDistrict.sqlite

# Init DB
>$DBFILE
sqlite3 $DBFILE '''
CREATE TABLE Employee (EmployerName TEXT, Position TEXT, RegularPay INTEGER, OvertimePay INTEGER, LumpSumPay INTEGER, OtherPay INTEGER, TotalWages INTEGER,  HealthDentalVision INTEGER, FacultyType TEXT);
'''

# Import data
python3 gcc-2016_CommunityCollegeDistrict.py

# DB Indexes
for col in EmployerName Position RegularPay OvertimePay LumpSumPay OtherPay TotalWages HealthDentalVision FacultyType; do
  sqlite3 $DBFILE "CREATE INDEX idx$col ON Employee($col);"
done 

# Estimate FT/PT faculty
sqlite3 -cmd '.load /usr/lib/sqlite3/pcre.so' $DBFILE '''
UPDATE Employee SET FacultyType = "PT" WHERE
  (
    Position REGEXP "((Pt|Nc) Fac)|(Academic, Temporary)|(Adjunct)|(Teacher \(Hourly\))|(Aft\/Pt)|(Part[\- ]Time (Fac|Inst))|(^Adj)"
    OR
      (
        (Position LIKE "%inst%" OR Position LIKE "%fac%")
        AND
        Position NOT LIKE "%facilities%"
        AND
        ( Position LIKE "%part %"
         OR Position LIKE "%part-%"
         OR Position LIKE "%pt"
         OR Position LIKE "%pt %"
         OR Position LIKE "%hrly%"
         OR Position LIKE "%hourly%"
         OR Position LIKE "%temp%"
         OR Position LIKE "%associate%"
        )
      )
    OR
    EmployerName = "Chaffey Community College District" AND Position LIKE "Lecture%"
    OR
    EmployerName = "MiraCosta Community College District" AND Position = "Teacher"
    OR
    EmployerName = "Napa Valley Community College District" AND Position LIKE "Pt%"
    OR
    EmployerName = "Redwoods Community College District" AND Position LIKE "Associate Faculty%"
  )
  AND Position NOT LIKE "Full%"
  AND Position NOT LIKE "%dept chair%"
;
'''

sqlite3 -cmd '.load /usr/lib/sqlite3/pcre.so' $DBFILE '''
UPDATE Employee SET FacultyType = "FT" WHERE
  FacultyType IS NULL
  AND
  (
    Position REGEXP "(Ft Fac)|(Teacher \(Reg\))|(Full[\- ]Time (Fac|Inst))|(Aft F\/T)|(Professor)"
    OR
    EmployerName IN
      ("Cabrillo Community College District", "Barstow Community College District", "Coast Community College District",
       "Desert Community College District", "Feather River Community College District", "Foothill-De Anza Community College District",
       "Gavilan Joint Community College District", "Hartnell Community College District", "Lake Tahoe Community College District",
       "Los Angeles Community College District", "Merced Community College District", "Mt. San Jacinto Community College District",
       "North Orange County Community College District", "Peralta Community College District",
       "San Bernardino Community College District", "San Joaquin Delta Community College District",
       "San Jose/Evergreen Community College District", "San Mateo County Community College District",
       "Siskiyou Joint Community College District", "South Orange County Community College District",
       "Southwestern Community College District", "State Center Community College District",
       "Ventura County Community College District")
      AND
        (Position = "Instructor" OR Position = "Faculty" OR Position LIKE "%Instructor" OR Position LIKE "Instructor%")
      AND Position NOT LIKE "%Adjunct%"
      AND Position NOT LIKE "%Part%"
      AND Position NOT LIKE "%Associate%"
      AND Position NOT LIKE "%Hrly%"
      AND Position NOT LIKE "%Hourly%"
    OR
    EmployerName = "MiraCosta Community College District" AND Position = "Instructor - Community College"
    OR
    EmployerName = "Napa Valley Community College District" AND Position LIKE "Instructor%"
    OR
    EmployerName = "Redwoods Community College District" AND Position LIKE "Professor%"
    OR
    EmployerName = "San Diego Community College District" AND Position LIKE "%Contract"
    OR
    EmployerName = "Sonoma County Junior College District" AND Position = "Faculty"
    OR
    EmployerName = "Yosemite Community College District" AND Position LIKE "%Instructor%"
  )
  AND Position NOT LIKE "%temp%"
;
'''

sqlite3 $DBFILE 'vacuum;'
