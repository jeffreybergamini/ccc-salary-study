#!/bin/bash
rm -f salary-data.sqlite
sqlite3 salary-data.sqlite < salary-data.sql
./import_data.py
sqlite3 salary-data.sqlite 'vacuum;'
