#!/usr/bin/env python3

from os import path

infile='template.html'
outfile='dlplayer.html'

if not path.exists(infile):
    print("Template file not found.")
    exit(1)

with open(infile, encoding='UTF-8') as f:
    filetext = f.read()

with open('style.css', encoding='UTF-8') as f:
    style = f.read()

with open('range-style.css', encoding='UTF-8') as f:
    rangestyle = f.read()

with open('player.js', encoding='UTF-8') as f:
    player = f.read()

for pattern, replacement in (('%STYLE%', style),
                             ('%RANGESTYLE%', rangestyle),
                             ('%PLAYER%', player)):
    filetext = filetext.replace(pattern, replacement)

with open(outfile, 'w', encoding='UTF-8') as f:
    f.write(filetext)

print('Data written to {}.'.format(outfile))
