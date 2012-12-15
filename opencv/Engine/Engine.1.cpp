#include <cv.h>
#include <highgui.h>

using namespace cv;
using namespace std;

int main( int argc, char** argv )
{
  int nPic = atoi(argv[1]);
  cout<<nPic<<"|"<<argc<<endl;
  Mat src[nPic],hsv[nPic];
  MatND hist[nPic];
  char buffer[128]={0};
  if(argc!=3)
  {
    cout<<"Params Error"<<endl;
    return -1;
  }
  
  for(int i=0;i<nPic;i++)
  {
    sprintf(buffer,"%d.jpg",i+1);
    src[i] = imread(buffer,1);
    sprintf(buffer,"SRC%d",i);
    namedWindow(buffer,CV_WINDOW_AUTOSIZE);
    imshow(buffer,src[i]);
    cvtColor(src[i],hsv[i],CV_BGR2HSV);
  }

  int h_bins = 50, s_bins = 60;
  int histSize[] = {h_bins,s_bins};
  float h_ranges[] = {0,256};
  float s_ranges[] = {0,180};
  
  const float* ranges[] = {h_ranges,s_ranges};
  
  int channels[] = {0,1};
  
  for(int i=0;i<nPic;i++)
  {
    calcHist(&hsv[i],1,channels,Mat(),hist[i],2,histSize,ranges,true,false);
    normalize(hist[i],hist[i],0,1,NORM_MINMAX,-1,Mat());
  }
  
  double res[3];
  
//  for(int j=0;j<nPic;j++)
//  {
//    cout<<"Method:"<<j<<'\t';
//    for(int i=0;i<3;i++)
//    {
      res[1] = compareHist(hist[3],hist[0],1);
//      cout<<i<<":"<<res[i]<<'\t';
//    }
//    cout<<endl;
 // }
    
  
  /*
  
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
  */
  waitKey(0);
  
  return 0;
}
