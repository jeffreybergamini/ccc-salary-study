-- Full-time annual salary
-- ma_plus: 0 (MA), 30 (MA + 60 units), 60 (MA + 90 units), 100 (PhD)
-- Steps: 1, 6, 11, 21; Step for ma_plus 100 (PhD) ==> first step for max salary
-- ma+0step1, ma+0step6, ma+30step11, ma+60step21, phdstepXX
CREATE TABLE ft_salary (district TEXT, ma_plus INTEGER, step INTEGER, salary INTEGER, hourly REAL);
CREATE INDEX ft_salary_district_idx ON ft_salary (district);
CREATE INDEX ft_salary_ma_plus_idx ON ft_salary (ma_plus);
CREATE INDEX ft_salary_step_idx ON ft_salary (step);
CREATE INDEX ft_salary_salary_idx ON ft_salary (salary);

-- Part-time hourly pay
-- ma_plus: 0 (MA), 30 (MA + 60 units), 60 (MA + 60 units), 100 (PhD)
-- Steps: 1, 5, 10, 0 (max)
-- ma+0step1, ma+0step5, ma+30step10, ma+60stepXX (not actually 60; highest w/out PhD), phdstepXX
CREATE TABLE pt_salary (district TEXT, ma_plus INTEGER, step INTEGER, salary INTEGER, hourly REAL);
CREATE INDEX pt_salary_district_idx ON pt_salary (district);
CREATE INDEX pt_salary_ma_plus_idx ON pt_salary (ma_plus);
CREATE INDEX pt_salary_step_idx ON pt_salary (step);
CREATE INDEX pt_salary_hourly_idx ON pt_salary (hourly);

-- Zillow Home Value Index and National Association of Realtors Qualifying Income
CREATE TABLE home_value (zip INTEGER, zhvi INTEGER, qinc INTEGER);
CREATE INDEX home_value_zip_idx ON home_value(zip);
CREATE INDEX home_value_idx ON home_value(zhvi);

-- Districts and their main ZIP codes
CREATE TABLE district (district TEXT, zip INTEGER);
CREATE INDEX district_district_idx ON district(district);
CREATE INDEX district_zip_idx ON district(zip);

-- All ZIP codes
CREATE TABLE zip (zip INTEGER PRIMARY KEY, latitude REAL, longitude REAL);
CREATE INDEX zip_zip_idx ON zip(zip);

-- Distance between ZIP codes
CREATE TABLE zip_distance (src INTEGER, dst INTEGER, distance REAL);
CREATE INDEX zip_distance_src_idx ON zip_distance(src);
CREATE INDEX zip_distance_dst_idx ON zip_distance(dst);
