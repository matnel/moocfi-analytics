FILE = '../data/points-all.json'
URL = 'http://tmc.mooc.fi/mooc/courses/15/points.csv'

import json
import csv
import urllib2

import common as c

## load previous data if needed
try:
	data = json.load( open( FILE, 'r') )
except IOError:
	data = {}

web = csv.DictReader( urllib2.urlopen( URL ) )

for line in web:
	username = line['Username'];
	if username not in data:
		data[ username ] = {
			'group' : c.group( line['Username'] ),
			'data' : []
		}
	d = { 'time' : c.now(), 'points' : int( line['Total'] ) }
	data[username]['data'].append( d )

json.dump( data, open( FILE, 'w') )
