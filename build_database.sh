#!/bin/bash
rm -f salary-data.sqlite
sqlite3 salary-data.sqlite < salary-data.sql
./gcc-2016_CommunityCollegeDistrict.sh
./import_data.py
sqlite3 salary-data.sqlite 'vacuum;'
