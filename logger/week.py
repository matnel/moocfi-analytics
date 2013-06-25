FILE = 'points-week1.json'
URL = 'http://tmc.mooc.fi/mooc/courses/15/points/1?layout=0'

from bs4 import BeautifulSoup
import urllib2
import json
import common as c

html = BeautifulSoup( urllib2.urlopen( URL ) )
table = html.table

header = table.tr.find_all('th')
header = map( lambda x : x.string.strip() if x.string else '', header )

data = {}

for s in table.find_all('tr', 'student'):
	cols = s.find_all('td')
	## first td is user name
	d = {};

	username = cols[0].string.strip()
	color = c.group( username )
	tasks = map( lambda x : x.string != None, cols[1:] )

	if color not in data:
		data[color] = []


	d['color'] = color
	d['tasks'] = tasks

	data[color].append( tasks )
	data['_' + username] = d

print json.dumps( data )