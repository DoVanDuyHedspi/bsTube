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
        this.renderComments = this.renderComments.bind(this); 
    }

    getComments() {
        this.setState({loading:true});    
        axios.get('/comments', {params: {channel_name: this.props.name}}).then((
            response
        ) => 
            this.setState({
                comments: [...response.data.comments],
                loading: false
            })
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

    renderComments() {
        return this.state.comments.map(comment => (
            <div key={comment.id} className="media">
                <div className="media-left">
                    {/* <img src={comment.user.avatar} className="media-object mr-2" /> */}
                </div>
                <div className="media-body">
                    <div className="user">
                        {/* <a href={`users/${comment.user.username}`}> */}
                            {/* <b>{comment.user.username}</b> */}
                        {/* </a>{' '} */}
                        - {comment.humanCreatedAt}
                    </div>         
                    <p>{comment.content}</p>
                </div>                                                          
            </div>))
        
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center col-md-6">
                    <div className="col-md-12">
                        <div className="card">
                            <div className="card-header">Recent tweets </div>
                            
                            <div className="card-body">
                            {!this.state.loading ? this.renderComments() : 'Loading'}
                            </div>
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div className="card">
                            <div className="card-header">Tweet something...</div>

                            <div className="card-body">
                                <form onSubmit={this.handleSubmit}>
                                    <div className="form-group">
                                        <textarea
                                            onChange={this.handleChange}
                                            value={this.state.content}
                                            className="form-control"
                                            row="5"
                                            maxLength="140"
                                            placeholder="What up?"
                                            required />
                                    </div>
                                    <input type="submit" value="Post" className="form-control"/>
                                </form>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        );
    }
}

export default App;
