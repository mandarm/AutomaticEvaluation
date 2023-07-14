import sys

file_name=sys.argv[1]

file1 = open(file_name, 'r')
Lines = file1.readlines()
N=int(Lines[0])
cnt=0
for i in range(N):
	if i>6:
		i=i+5
	if (i%2==0 and i>1):
		print(i, end =" ")


file1.close()
