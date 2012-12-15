import cv
cv.NamedWindow("lena",cv.CV_WINDOW_AUTOSIZE)
image=cv.LoadImage("lena.jpg",1)
cv.ShowImage("lena",image)
cv.WaitKey(0)
