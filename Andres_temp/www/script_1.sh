#! /bin/bash
cd ../..

ffmpeg -i html/media/html5/$1 -vf "scale=1280:720:force_original_aspect_ratio=decrease,pad=1280:720:(ow-iw)/2:(oh-ih)/2" -c:v libx264 -strict -2  html/media/html5/$2.mp4
rm html/media/html5/$1

ffmpeg -i html/media/html5/$2.mp4 -r 1 -ss 00:00:01 -frames:v 1  html/media/thumbnails/$2.jpg

mkdir html/media/dash/$2

ffmpeg -i html/media/html5/$2.mp4 -an -c:v copy html/media/dash/$2/$2_v.mp4
ffmpeg -i html/media/html5/$2.mp4 -vn -c:a copy html/media/dash/$2/$2_a.mp4

ffmpeg -i html/media/dash/$2/$2_v.mp4 -c:v copy -r 24 -g 24 -b:v 1000k -maxrate 1000k -bufsize 2000k html/media/dash/$2/$2_v-1000k.mp4
ffmpeg -i html/media/dash/$2/$2_v.mp4 -c:v copy -r 24 -g 24 -b:v 500k -maxrate 500k -bufsize 1000k html/media/dash/$2/$2_v-500k.mp4
ffmpeg -i html/media/dash/$2/$2_v.mp4 -c:v copy -r 24 -g 24 -b:v 250k -maxrate 250k -bufsize 500k html/media/dash/$2/$2_v-250k.mp4

rm html/media/dash/$2/$2_v.mp4

cd html/media/dash/$2
MP4Box -dash 4000 -profile onDemand -out $2.mpd $2_a.mp4 $2_v-1000k.mp4 $2_v-500k.mp4 $2_v-250k.mp4

rm $2_a.mp4
rm $2_v-1000k.mp4
rm $2_v-500k.mp4
rm $2_v-250k.mp4
