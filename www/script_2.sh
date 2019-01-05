#! /bin/bash
cd ../..

ffmpeg -i html/media/perfil/$1 -vf "scale=286:286:force_original_aspect_ratio=decrease,pad=286:286:(ow-iw)/2:(oh-ih)/2" -strict -2 html/media/perfil/temp.jpg
rm html/media/perfil/$1
mv html/media/perfil/temp.jpg html/media/perfil/$2.jpg

