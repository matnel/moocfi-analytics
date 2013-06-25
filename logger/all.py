FILE = 'points-all.json'
URL = 'http://tmc.mooc.fi/mooc/courses/13/points.csv'

import json
import datetime
import csv
import urllib2

import common as c

all_data = json.load( open( FILE, 'r') )

data = csv.DictReader( urllib2.urlopen( URL ) )

out = {
	'time' : datetime.datetime.now().isoformat(),
	'data' : []
}

for line in data:
	d = {
		'username' : line['Username'],
		'group' : c.group( line['Username'] ),
		'points' : line['Total']
	}
	out['data'].append( d )

all_data.append( out )

print all_data

json.dump( all_data, open( FILE, 'w') )