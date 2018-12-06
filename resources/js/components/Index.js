import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import Youtube from './PlayVideo';

if (document.getElementById('comment')) {
    var channel_name = document.getElementById('channel_name').value;
    ReactDOM.render(<App name={channel_name} />, document.getElementById('comment'));
}

if (document.getElementById('youtube')) {
    ReactDOM.render(<Youtube name={channel_name} />, document.getElementById('youtube'));
}


