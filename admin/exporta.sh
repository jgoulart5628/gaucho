#!/bin/bash
DBTODUMP=gaucho
SQL="SET group_concat_max_len = 10240;"
SQL="${SQL} SELECT GROUP_CONCAT(table_name separator ' ')"
SQL="${SQL} FROM information_schema.tables WHERE table_schema='${DBTODUMP}'"
# SQL="${SQL} AND table_name NOT IN ('t1','t2','t3')"
TBLIST=`mysql -uroot -pjogola01 -AN -e"${SQL}"`
# echo $TBLIST
echo 'mysqldump -uroot -pjogola01 ${DBTODUMP} ${TBLIST} > gaucho.sql'
