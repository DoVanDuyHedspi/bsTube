import React, { Component } from 'react';
import axios from 'axios';

class App extends Component {

    constructor(props) {
        super(props);
        this.state = {
            content: '',
            comments: [],
            loading: false,
            members: [],
            numberOfMembers: 0

        };
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.handleKeyPress = this.handleKeyPress.bind(this);
        this.renderComments = this.renderComments.bind(this); 
        this.renderListMembers = this.renderListMembers.bind(this); 
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
            }
            
        );
    }

    componentWillMount() {
        this.getComments();
    }

    removeMembersInList(array, element) {
      const index = array.indexOf(element);
      array.splice(index, 1);
    }

    componentDidMount() {
        Echo.join(`channel.${this.props.name}`)
            .here((users) => {
                axios
                    .put('/channel/update_numbers_members', {
                        numbersOfMembers: users.length,
                        channel_name: this.props.name
                    });
                this.setState({
                    members: [...users],
                    numberOfMembers: users.length
                });
            })
            .joining((user) => {
              this.setState({
                members: [...this.state.members,user],
                numberOfMembers: this.state.numberOfMembers+1
              });
            })
            .leaving((user) => {
                axios
                    .put('/channel/update_numbers_members', {
                        numbersOfMembers: this.state.numberOfMembers-1,
                        channel_name: this.props.name
                    });
                const listMembers = this.state.members;
                this.removeMembersInList(listMembers,user);
                this.setState({
                  members: [...listMembers],
                  numberOfMembers: this.state.numberOfMembers-1
                });
            })
            .listen('CommentCreated', (e) => {
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

    renderListMembers() {
        return this.state.members.map(user => (
          <div key={user.id} className="userlist_item userlist_afk">
            <span className="glyphicon glyphicon-time"></span>
            <span className="userlist_op" style={{fontStyle: 'italic'}}>{user.username}</span>
          </div>
        ))
    }

    render() {
        return (
            <div className="">
                <div className="col-md-12" id="chatwrap">
                    <div id="chatheader">
                        <i className="glyphicon glyphicon-chevron-down pull-left pointer" id="userlisttoggle" title="Show/Hide Userlist"></i>
                        <span className="pointer" id="usercount">{this.state.numberOfMembers} connected users</span>
                    </div>
                    <div id="userlist" style={{height: 388 + 'px'}}> 
                      {this.renderListMembers()}   
                    </div>
                    <div className="linewrap" id="messagebuffer" style={{height: 388 + 'px'}}>
                        <div className="server-msg-reconnect">Connected</div>
                        {!this.state.loading ? this.renderComments() : 'Loading'}
                    </div>
                    <div className="input-group col-xs-12" id="guestlogin">
                        {/* <span className="input-group-addon">Guest login</span> */}
                        <form onSubmit={this.handleSubmit}>
                            <div className="form-group">
                                <input 
                                    className="form-control" 
                                    id="guestname" 
                                    type="text" 
                                    placeholder="What's up!"
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
