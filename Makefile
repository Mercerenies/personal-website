
CC=coffee --compile --output js/

.PHONY:	debug

all:	js/games.js js/projects.js js/spaces.js js/interactive.js js/algebra.js
	$(CC) coffee/games.coffee coffee/projects.coffee coffee/spaces.coffee coffee/interactive.coffee coffee/algebra.coffee

debug:	js/games.js js/projects.js js/spaces.js js/interactive.js js/algebra.js
	$(CC) --map coffee/games.coffee coffee/projects.coffee coffee/spaces.coffee coffee/interactive.coffee coffee/algebra.coffee
