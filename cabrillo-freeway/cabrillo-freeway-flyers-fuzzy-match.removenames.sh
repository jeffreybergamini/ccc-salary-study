grep -vP "$(tr '\n' '|' < cabrillo-freeway-flyers-fuzzy-match.namesremoved.txt)" < cabrillo-freeway-flyers-fuzzy-match.csv > cabrillo-freeway-flyers-fuzzy-match.namesremoved.csv
