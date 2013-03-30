#!/bin/sh

clear
grep -a1 "canonical" starred.json > new.txt
grep -v "^\--" new.txt > newnew.txt
grep -v "} ]," newnew.txt > new.txt
grep -v "\"canonical\" : \[ {" new.txt > newnew.txt
grep -v "\"updated" newnew.txt > new.txt
grep -v "} \]," new.txt > newnew.txt
cat newnew.txt | rev | cut -c 2- | rev > new.txt
cut -c 17- new.txt > newnew.txt
rm -r new.txt
mv newnew.txt url.txt
