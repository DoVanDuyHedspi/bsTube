import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import Youtube from './PlayVideo';


var channel_name = document.getElementById('channel_name').value;
axios.get('/channel/start_video_time', {params: {channel_name: channel_name}}).then((res) => {
        var start_video_time = res.data.datetime;
        console.log(start_video_time);
        if (document.getElementById('youtube')) {
            ReactDOM.render(<Youtube name={channel_name} startTime={start_video_time} />, document.getElementById('youtube'));
        }
    });
if (document.getElementById('comment')) {
    ReactDOM.render(<App name={channel_name} />, document.getElementById('comment'));
}




