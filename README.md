## About Phungeon


Phungeon is a relatively small dungeon crawler game, made in php.
It is created to run in a Terminal, as it is a php cli based game.

The game is created with docker in mind. Running the game outside of docker can work, but i have not tested that.

If you have docker installed

```bash
docker-compose up
docker-compose exec app /bin/bash
composer-install
```

## starting the game
```bash
php game start
```

## playing the game

### Movement
The game is played with wasd
```markdown
w=up
s=down
a=left
d=right
```

### Enemies ###

There are enemies. Walking over them will attack the enemies.
Enemies will try to follow you.

### items ###
Items are automatically picked up and put in your inventory. (unless your inventory is full).
An item is displayed as a yellow star.


The items can then be used with the corresponding key (1 to 9).





