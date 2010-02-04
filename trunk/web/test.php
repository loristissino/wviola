<pre>
<?php

echo "this is a test\n";

$movie = new ffmpeg_movie('/var/wviola/data/filesystem/sources/videos/video2.mpg');

echo $movie->getDuration() . " the duration of a movie or audio file in seconds.\n";
echo $movie->getFrameCount() 	. " the number of frames in a movie or audio file.\n";
echo $movie->getFrameRate() 	. " the frame rate of a movie in fps.\n";
echo $movie->getFilename() 	. " the path and name of the movie file or audio file.\n";
echo $movie->getComment() 	. " the comment field from the movie or audio file.\n";
echo $movie->getTitle() 	. " the title field from the movie or audio file.\n";
echo $movie->getAuthor()	. " the author field from the movie or the artist ID3 field from an mp3 file.\n";
echo $movie->getCopyright() 	. " the copyright field from the movie or audio file.\n";
echo $movie->getArtist() 	. " the artist ID3 field from an mp3 file.\n";
echo $movie->getGenre() 	. " the genre ID3 field from an mp3 file.\n";
echo $movie->getTrackNumber() 	. " the track ID3 field from an mp3 file.\n";
echo $movie->getYear() 	. " the year ID3 field from an mp3 file.\n";
echo $movie->getFrameHeight() 	. " the height of the movie in pixels.\n";
echo $movie->getFrameWidth() 	. " the width of the movie in pixels.\n";
echo $movie->getPixelFormat() 	. " the pixel format of the movie.\n";
echo $movie->getBitRate() 	. " the bit rate of the movie or audio file in bits per second.\n";
echo $movie->getVideoBitRate() 	. " the bit rate of the video in bits per second.\n";

echo $movie->getAudioBitRate() 	. " the audio bit rate of the media file in bits per second.\n";
echo $movie->getAudioSampleRate() 	. " the audio sample rate of the media file in bits per second.\n";
echo $movie->getFrameNumber() 	. " the current frame index.\n";
echo $movie->getVideoCodec() 	. " the name of the video codec used to encode this movie as a string.\n";
echo $movie->getAudioCodec() 	. " the name of the audio codec used to encode this movie as a string.\n";
echo $movie->getAudioChannels() 	. " the number of audio channels in this movie as an integer.\n";
echo $movie->hasAudio() 	. " boolean value indicating whether the movie has an audio stream.\n";
echo $movie->hasVideo() 	. " boolean value indicating whether the movie has a video stream.\n";
//echo $movie->getFrame(3)  . " a frame from the movie as an ffmpeg_frame object.  Returns false if the frame was not found.\n";

$frame=$movie->getFrame(3);
echo $frame->getWidth() . " frame width\n";

$gdimage=$frame->toGDImage();

imagejpeg($gdimage, '/tmp/mytest.jpg');

//echo $movie->getNextKeyFrame() . " next key frame\n";




