project( Engine )
find_package( OpenCV REQUIRED )
add_executable( Engine Engine )
target_link_libraries( Engine ${OpenCV_LIBS} )
