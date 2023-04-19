#!/bin/bash
HOJE=`date +%Y%m%d_%H%M`
ARQ=`echo gaucho_${HOJE}`
mysqldump -uroot -pjogola01 gaucho > $ARQ.sql
