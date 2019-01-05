#! /bin/bash

mv ../media/videos/$1 ../media/videos/$2.mp4

ffmpeg -i ../media/videos/$2.mp4 -r 1 -ss 00:00:01 -frames:v 1 ../media/caratulas/$2.jpg
