DEFAULT_GROUP = 'grey'
GROUP_FILE = 'groups.csv'

import csv
import datetime

g = {}

d = csv.DictReader( open( GROUP_FILE, 'r' ) )

for l in d:
	g[ l['username'] ] = l['color']

def group(username):
	if username in g:
		return g[username]
	else:
		return DEFAULT_GROUP

def now():
	return datetime.datetime.now().isoformat()
