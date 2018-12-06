import React from 'react';
import YouTube from 'react-youtube';
 
class PlayVideo extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      playlist: [],
    };

    this.renderPlaylist = this.renderPlaylist.bind(this);
  }

  getPlaylist() {
    axios.get('/channel/playlist', {params: {channel_name: this.props.name}}).then((
        response
    ) => {
            this.setState({
                playlist: [...response.data.playlist]
            });
            console.log(response)
        }
        
    )
  }

  componentWillMount() {
    this.getPlaylist();
  }

  renderPlaylist() {
    return (
      <div>
        <ul className="videolist ui-sortable ui-sortable-disabled" id="queue">
          {this.state.playlist.map(link => (
            <li className="queue_entry queue_temp"><a className="qe_title" href="#" target="_blank">Saori Hara FULL</a><span className="qe_time">01:30:51</span>
              <div className="qe_clear"></div>
            </li>
          ))}
          {/* <li className="queue_entry queue_temp queue_active"><a className="qe_title" href="#" target="_blank">First stream media</a><span className="qe_time">00:00</span>
            <div className="qe_clear"></div>
          </li> */}
          
        </ul>
        <div id="plmeta"><span id="plcount">4 items</span><span id="pllength">01:49:57</span>
        </div>
      </div>
    )
    
  }

  render() {
    const opts = {
      height: '390',
      width: '100%',
      playerVars: { // https://developers.google.com/youtube/player_parameters
        autoplay: 1
      }
    };
 
    return (
      <div id="controlsrow">
        <div id="videowrap">
          <p id="videowrap-header" className="text-center">Video's name</p>
          <YouTube
            videoId="2g811Eo7K8U"
            opts={opts}
            // onReady={this._onReady}
          />
        </div>
        <div id="rightcontrols">
          <div className="btn-group" id="plcontrol">
            <button className="btn btn-sm btn-default " id="showsearch" title="Search for a video" data-toggle="collapse" data-target="#searchcontrol" aria-expanded="true" aria-pressed="true"><span className="glyphicon glyphicon-search"></span>
            </button>
            <button className="btn btn-sm btn-default " id="showsearch" title="Search for a video" data-toggle="collapse" data-target="#addfromurl" aria-expanded="true" aria-pressed="true"><span className="glyphicon glyphicon-plus"></span>
            </button>   
            <button className="btn btn-sm btn-default collapsed" id="showplaylistmanager" title="Manage playlists" data-toggle="collapse" data-target="#playlistmanager" aria-expanded="false" aria-pressed="false"><span className="glyphicon glyphicon-list"></span>
            </button>
            <button className="btn btn-sm btn-success" id="qlockbtn" title="Playlist Unlocked" disabled="disabled"><span className="glyphicon glyphicon-ok"></span>
            </button>
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
                  <input className="form-control" id="library_query" type="text" placeholder="Search query"></input>
                  <span className="input-group-btn"><button className="btn btn-default" id="next">Next</button></span>
                  <span className="input-group-btn"><button className="btn btn-default" id="adEnd">At end</button></span>
                </div>
                <div className="checkbox">
                  <label>
                    <input className="add-temp" type="checkbox" defaultChecked></input><span>Add as temporary</span>
                  </label>
                </div>
                <div id="addfromurl-queue"></div>
              </div>
              {/* <div className="plcontrol-collapse col-lg-12 col-md-12 collapse" id="customembed" aria-expanded="false" style={{height: 206+ 'px'}}>
                <div className="vertical-spacer"></div>
                <div className="checkbox">
                  <label>
                    <input className="add-temp" type="checkbox"></input><span>Add as temporary</span>
                  </label>
                </div>
              </div> */}
              <div className="plcontrol-collapse col-lg-12 col-md-12 collapse" id="playlistmanager" aria-expanded="false" style={{height: 0 + 'px'}}>
                <div className="vertical-spacer"></div>
                <div className="input-group">
                  <input className="form-control" id="userpl_name" type="text" placeholder="Playlist Name"></input>
                  <span className="input-group-btn"><button className="btn btn-default" id="userpl_save">Save</button></span>
                </div>
                <div className="checkbox">
                  <label>
                    <input className="add-temp" type="checkbox" defaultChecked></input><span>Add as temporary</span>
                  </label>
                </div>
                <ul className="videolist" id="userpl_list"></ul>
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
    // access to player in all event handlers via event.target
    event.target.pauseVideo();
  }
}

export default PlayVideo;