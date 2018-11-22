# Turing Machine with PHP

Finnaly, i found the PHP script for Turing Machine concept. Thanks to [igorw via gist github](https://gist.github.com/igorw)

So, this is the turing machine for addition, subtraction, multiplication, and division.

# Usage
1. Clone this code
2. Open the file you want to try it.
3. Change the tape array in
```
tape = []
```
4. Then Run it

# Explanation
1. If you want to test the code, the input tape is in unary. For example if you want to input 3 you must input 111, or 5 is 11111, etc.
2. For the operator is '+' for addition, '-' for substraction, '*' for multiplication,  and '/' for division.
3. So, example, if you want to write 4+3 , you must input 1111+111 or in tape array is looks like
```
tape = ['1','1','1','1','+','1','1','1'];
```
4. **important** for division only. Add '#' before and after the number. 
5. The result is the number of zero (0) after '_' character.
