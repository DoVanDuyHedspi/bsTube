import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import App from './App'

if (document.getElementById('root')) {
    var channel_name = document.getElementById('channel_name').value;
    ReactDOM.render(<App name={channel_name} />, document.getElementById('root'));
}
