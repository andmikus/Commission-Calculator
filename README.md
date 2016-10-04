# Commission-Calculator
Calculate commission fees for given cash in/out transactions.

Usage example:

```
➜  cat input.csv 
2016-01-05,1,natural,cash_in,200.00,EUR
2016-01-06,2,juridical,cash_out,300.00,EUR
2016-01-06,1,natural,cash_out,30000,JPY
2016-01-07,1,natural,cash_out,1000.00,EUR
2016-01-07,1,natural,cash_out,100.00,USD
2016-01-10,1,natural,cash_out,100.00,EUR
2016-01-10,2,juridical,cash_in,1000000.00,EUR
2016-01-10,3,natural,cash_out,1000.00,EUR
2016-02-15,1,natural,cash_out,300.00,EUR
➜  php script.php input.csv
0.06
0.90
0
0.70
0.30
0.30
5.00
0.00
0.00
```
