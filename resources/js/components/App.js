import React, { Component } from 'react';
import axios from 'axios';

class App extends Component {

    constructor(props) {
        super(props);
        this.state = {
            content: '',
            comments: [],
            loading: false
        };
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.handleKeyPress = this.handleKeyPress.bind(this);
        this.renderComments = this.renderComments.bind(this); 
    }

    getComments() {
        this.setState({loading:true});    
        axios.get('/comments', {params: {channel_name: this.props.name}}).then((
            response
        ) => {
                this.setState({
                    comments: [...response.data.comments],
                    loading: false
                });
                console.log(response)
            }
            
        );
    }

    componentWillMount() {
        this.getComments();
    }

    componentDidMount() {
        Echo.join(`channel.${this.props.name}`)
            .here(function(){
                console.log(`duy`)
            })
            .listen('CommentCreated', (e) => {
                console.log(e);
                this.setState({comments: [...this.state.comments, e.comment]})
            })
    }

    componentWillUnmount() {
    }

    handleSubmit(e) {
        e.preventDefault();
        axios
            .post('/comments', {
                content: this.state.content,
                channel_name: this.props.name
            })
            .then(response => {
                this.setState({
                    comments: [...this.state.comments, response.data],
                    content: ''                    
                })
            });                                 
        this.setState({                       
            content: ''
        });
                                            
    }

    postData() {
        axios.post('/comments', {
            content: this.state.content
        });
    }
                                           
    handleChange(e) {
        
        this.setState({
            content: e.target.value
        })
    }

    handleKeyPress(e) {
        console.log(e)
        if(e.key == 'Enter') {
            this.handleSubmit(e)
        }
    }

    renderComments() {
        return this.state.comments.map(comment => (
            <div key={comment.id} className="media">
                <div style={{color: 'green'}}>
                    <span>[{comment.humanCreatedAt}] </span><span>{comment.user.username}: {comment.content}</span>
                </div>                                                           
            </div>))
        
    }

    render() {
        return (
            <div className="">
                <div className="col-md-12" id="chatwrap">
                    <div id="chatheader">
                        <i className="glyphicon glyphicon-chevron-down pull-left pointer" id="userlisttoggle" title="Show/Hide Userlist"></i>
                        <span className="pointer" id="usercount">4 connected users</span>
                    </div>
                    <div id="userlist" style={{height: 388 + 'px'}}>
                        <div className="userlist_item userlist_afk">
                            <span className="glyphicon glyphicon-time"></span>
                            <span className="userlist_op" style={{fontStyle: 'italic'}}>AlbanianAndy</span>
                        </div>
                    </div>
                    <div className="linewrap" id="messagebuffer" style={{height: 388 + 'px'}}>
                        <div className="server-msg-reconnect">Connected</div>
                        {!this.state.loading ? this.renderComments() : 'Loading'}
                    </div>
                    <div className="input-group" id="guestlogin">
                        {/* <span className="input-group-addon">Guest login</span> */}
                        <form onSubmit={this.handleSubmit}>
                            <div className="form-group">
                                <input 
                                    className="form-control" 
                                    id="guestname" 
                                    type="text" 
                                    placeholder="Name"
                                    onChange={this.handleChange}
                                    onKeyPress={this.handleKeyPress} 
                                    value={this.state.content}
                                    maxLength="140" 
                                    required   
                                >
                                </input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        );
    }
}

export default App;
