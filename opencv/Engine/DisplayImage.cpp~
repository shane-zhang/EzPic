#include <cv.h>
#include <highgui.h>

using namespace cv;
using namespace std;

int main( int argc, char** argv )
{
  Mat src,hsv;
  src = imread(argv[1],1);
  if(argc !=2 ||!src.data)
    return -1;
  
  cvtColor(src,hsv,CV_BGR2HSV);
  namedWindow("Source",CV_WINDOW_AUTOSIZE);
  imshow("Source",src);
  namedWindow("HSV",CV_WINDOW_AUTOSIZE);
  imshow("HSV",hsv);
  waitKey(0);
  
  int hbins = 30,sbins = 32;
  int histSize[] = {hbins,sbins};
  float hranges[] = {0,180};
  float sranges[] = {0,256};
  const float* ranges[] = {hranges,sranges};
  Mat hist;
  int channels[] = {0,1};
  
  calcHist(&hsv,1,channels,Mat(),hist,2,histSize,ranges,true,false);
  
  namedWindow("hits",CV_WINDOW_AUTOSIZE);
  imshow("hits",hist);
  waitKey(0);
  
  double minVal= 0,maxVal = 0;
  minMaxLoc(hist,&minVal,&maxVal,0,0);
  cout<<"Max Value"<<maxVal<<"Min Value"<<minVal<<endl;
  
  int scale = 10;
  Mat histImg = Mat::zeros(sbins*scale,hbins*scale,CV_8UC3);
  
  for(int h =0; h<hbins;h++)
  {
    for(int s=0; s<sbins;s++)
    {
      float binVal = hist.at<float>(h,s);
      int intensity =cvRound(binVal*255/maxVal);
      rectangle(histImg,
		Point(h*scale,s*scale),
		Point((h+1)*scale -1,(s+1)*scale -1),
		Scalar::all(intensity),
		CV_FILLED);
    }
  }
  
  namedWindow("HShist",CV_WINDOW_AUTOSIZE);
  imshow("HShist",histImg);
  waitKey(0);
  
  return 0;
}
