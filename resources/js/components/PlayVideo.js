import React from 'react';
import YouTube from 'react-youtube';
 
class PlayVideo extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      playlists: [],
      newLink: '',
      ableAddLink: 1,
      isMaster: false,
      startTime: this.props.startTime
    };

    this.renderPlaylist = this.renderPlaylist.bind(this);
    this.renderButtonPermissions = this.renderButtonPermissions.bind(this);
    this.handleChangeLink = this.handleChangeLink.bind(this);
    this.handleCLickButtonPermissions = this.handleCLickButtonPermissions.bind(this);
    this.handleAddLink = this.handleAddLink.bind(this);
    this.renderButtonAddLink = this.renderButtonAddLink.bind(this);
    this._nextVideo = this._nextVideo.bind(this);
  }

  getPlaylist() {
    axios.get('/channel/playlist', {params: {channel_name: this.props.name}}).then((
        response
    ) => {
            this.setState({
                playlists: [...response.data.playlists]
            });
        }
        
    )
  }

  getPermissionsStatus() {
    axios.get('/channel/permissions', {params: {channel_name: this.props.name}}).then((
      response
    ) => {
      if(response.data.isMaster) {
        this.setState({
          ableAddLink: response.data.status,
          isMaster: true
        })
      }else {
        this.setState({
          ableAddLink: response.data.status,
          isMaster: false
        })
      }
    }
    )
  }

  getPermissionsControll() {
    
  }

  componentWillMount() {
    this.getPlaylist();
    this.getPermissionsStatus();
  }

  componentDidMount() {
    Echo.join(`channel.${this.props.name}`)
        .listen('ChangePermissions', (e) => {
          this.setState({ableAddLink: e.status})
        })
        .listen('NextVideo', (e) => {
          const newPlaylists = this.state.playlists;
          newPlaylists.shift();
          this.setState({
            playlists: newPlaylists,
            startTime: 0  
          });
        })
        .listen('AddLink', (e)=> {
          const newPlaylists = e.playlists;
          this.setState({playlists: newPlaylists});
        })
}

  renderPlaylist() {
    return (
      <div>
        <ul className="videolist ui-sortable ui-sortable-disabled" id="queue">
          {this.state.playlists.map(video => (
            <li className="queue_entry queue_temp"><a className="qe_title" href="#" target="_blank">{video.snippet.title}</a><span className="qe_time">{video.contentDetails.duration}</span>
              <div className="qe_clear"></div>
            </li>
          ))}
        </ul>
        {/* <div id="plmeta"><span id="plcount">4 items</span><span id="pllength">01:49:57</span>
        </div> */}
      </div>
    )
    
  }

  handleCLickButtonPermissions() {
    axios
        .post('/channel/change_permissions', {
            status: this.state.ableAddLink,
            channel_name: this.props.name
        })
        .then(response => {
            this.setState({
                ableAddLink: response.data.status,          
            })
        });

  }

  //Add link
  handleAddLink(e) {
    axios
        .post('/channel/add_link', {
          channel_name: this.props.name,
          newLink: this.state.newLink,
          type: e.target.id
        })
        .then(response => {
          this.setState({
              playlists: response.data.newPlaylists,
              newLink: ''
          })
        });
  }

  handleChangeLink(e) {  
    this.setState({
        newLink: e.target.value
    })
  }

  renderButtonPermissions() {
    if(this.state.ableAddLink == 1){
      return (
        <button onClick={this.handleCLickButtonPermissions} className="btn btn-sm btn-success" id="qlockbtn" title="Playlist Unlocked" disabled={this.state.isMaster ? '' : 'disabled'}><span className="glyphicon glyphicon-ok"></span>
        </button>
      )
    }else if(this.state.ableAddLink != 1){
      return (
        <button onClick={this.handleCLickButtonPermissions} className="btn btn-sm btn-danger" id="qlockbtn" title="Playlist Unlocked" disabled={this.state.isMaster ? '' : 'disabled'}><span className="glyphicon glyphicon-lock"></span>
        </button>
      )
    }
  }

  renderButtonAddLink() {
    if(this.state.ableAddLink == 2 && this.state.isMaster == false) {
      return ('')
    } else {
      return (
        <button className="btn btn-sm btn-default " id="showsearch" title="Add a video" data-toggle="collapse" data-target="#addfromurl" aria-expanded="true" aria-pressed="true"><span className="glyphicon glyphicon-plus"></span>
        </button> 
      )
    }
  }



  _nextVideo() {
    if(this.state.isMaster){
      axios.put('/channel/removeFirstVideo', {channel_name: this.props.name})
          .then(res => {
            this.setState({
              playlists: res.data.newPlaylists,
              startTime: 0
            });
          })
    }
  }

  render() {
    const start_video_time = this.state.startTime;
    const opts = {
      height: '390',
      width: '100%',
      playerVars: { // https://developers.google.com/youtube/player_parameters
        autoplay: 1,
        start: start_video_time
      }
    };
    const id = this.state.playlists[0] != null ? this.state.playlists[0].id : ''
 
    return (      
      <div id="controlsrow">
        <div id="videowrap">
          <p id="videowrap-header" className="text-center">Video's name</p>
          <YouTube
            videoId={id}
            opts={opts}
            onEnd={this._nextVideo}
            // onReady={this._onReady}
          />
        </div>
        <div id="rightcontrols">
          <div className="btn-group" id="plcontrol">
            <button className="btn btn-sm btn-default " id="showsearch" title="Search for a video" data-toggle="collapse" data-target="#searchcontrol" aria-expanded="true" aria-pressed="true"><span className="glyphicon glyphicon-search"></span>
            </button>
            {this.renderButtonAddLink()}
            {this.renderButtonPermissions()}
          </div>
          <div className="btn-group pull-right" id="videocontrols">
            <button className="btn btn-sm btn-default" id="mediarefresh" title="Reload the video player"><span className="glyphicon glyphicon-retweet"></span>
            </button>
            <button className="btn btn-sm btn-default" id="fullscreenbtn" title="Make the video player fullscreen"><span className="glyphicon glyphicon-fullscreen"></span>
            </button>
            <button className="btn btn-sm btn-default" id="getplaylist" title="Retrieve playlist links"><span className="glyphicon glyphicon-link"></span>
            </button>
            <button className="btn btn-sm btn-default" id="voteskip" title="Voteskip"><span className="glyphicon glyphicon-step-forward"></span>
            </button>
          </div>
        </div>
        <div id="playlistrow">
          <div id="rightpane">
            <div className="row" id="rightpane-inner">
              <div className="plcontrol-collapse col-lg-12 col-md-12 collapse" id="searchcontrol" aria-expanded="true">
                <div className="vertical-spacer"></div>
                <div className="input-group">
                  <input className="form-control" id="library_query" type="text" placeholder="Search query"></input>
                  <span className="input-group-btn"><button className="btn btn-default" id="library_search">Library</button></span>
                  <span className="input-group-btn"><button className="btn btn-default" id="youtube_search">YouTube</button></span>
                </div>
                <div className="checkbox">
                  <label>
                    <input className="add-temp" type="checkbox" defaultChecked></input><span>Add as temporary</span>
                  </label>
                </div>
                <ul className="videolist col-lg-12 col-md-12" id="library"></ul>
              </div>
              <div className="plcontrol-collapse col-lg-12 col-md-12 collapse" id="addfromurl" aria-expanded="false" style={{height: 88+ 'px'}}>
                <div className="vertical-spacer"></div>
                <div className="input-group">
                  <input 
                      className="form-control" 
                      id="library_query" 
                      type="text"
                      value={this.state.newLink}
                      onChange={this.handleChangeLink}
                      placeholder="Add link">
                  </input>
                  <span className="input-group-btn"><button className="btn btn-default" id="next" onClick={this.handleAddLink}>Next</button></span>
                  <span className="input-group-btn"><button className="btn btn-default" id="atEnd" onClick={this.handleAddLink}>At end</button></span>
                </div>
                <div className="checkbox">
                  <label>
                    <input className="add-temp" type="checkbox" defaultChecked></input><span>Add as temporary</span>
                  </label>
                </div>
                <div id="addfromurl-queue"></div>
              </div>
              <div className="col-lg-12 col-md-12" id="queuefail">
                <div className="vertical-spacer"></div>
              </div>
              <div className="col-lg-12 col-md-12">
                {this.renderPlaylist()}
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
 
  _onReady(event) {
    event.target.pauseVideo();
  }
}

export default PlayVideo;