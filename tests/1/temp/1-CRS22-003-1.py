import sys

file_name=sys.argv[1]

file1 = open(file_name, 'r')
Lines = file1.readlines()
N=int(Lines[0])
cnt=0
for i in range(N):
	j=i+1
	print(j, end =" ")


file1.close()
