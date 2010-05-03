#!/bin/bash
if [ -z $3 ]
	then
		SCALE=16
	else
		SCALE=$3
	fi
convert $1 -scale "$SCALE!x$SCALE!" $2
chown loris:www-data $2

