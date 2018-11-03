import React, { Component } from 'react';
import axios from 'axios';

class App extends Component {

    constructor(props) {
        super(props);
        this.state = {
            body: '',
            posts: [],
            loading: false
        };
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.renderPosts = this.renderPosts.bind(this); 
    }

    getPosts() {
        this.setState({loading:true});
        axios.get('/posts').then((
            response
        ) => 
            this.setState({
                posts: [...response.data.posts],
                loading: false
            })
        );
    }

    componentWillMount() {
        this.getPosts();
    }

    componentDidMount() {
        Echo.private('new-post').listen('PostCreated', (e) => {
            console.log(window.Laravel.user.following.includes(e.post.user_id));
            // this.setState({posts: [e.post,...this.state.posts]})
            if (window.Laravel.user.following.includes(e.post.user_id)) {
                this.setState({posts: [e.post,...this.state.posts]})
            }
        })
        // this.interval = setInterval(()=>this.getPosts(), 10000)
    }

    componentWillUnmount() {
        // clearInterval(this.interval)
    }

    handleSubmit(e) {
        e.preventDefault();
        // this.postData();
        axios
            .post('/posts', {
                body: this.state.body
            })
            .then(response => {
                // console.log(response)
                this.setState({
                    posts: [...this.state.posts, response.data],
                    body: ''
                })
            });
        this.setState({
            body: ''
        });
        
    }

    postData() {
        axios.post('/posts', {
            body: this.state.body
        });
    }

    handleChange(e) {
        this.setState({
            body: e.target.value
        })
    }

    renderPosts() {
        return this.state.posts.map(post => (
            <div key={post.id} className="media">
                <div className="media-left">
                    <img src={post.user.avatar} className="media-object mr-2" />
                </div>
                <div className="media-body">
                    <div className="user">
                        <a href={`users/${post.user.username}`}>
                            <b>{post.user.username}</b>
                        </a>{' '}
                        - {post.humanCreatedAt}
                    </div>         
                    <p>{post.body}</p>
                </div>                                                          
            </div>))
        
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-6">
                        <div className="card">
                            <div className="card-header">Tweet something...</div>

                            <div className="card-body">
                                <form onSubmit={this.handleSubmit}>
                                    <div className="form-group">
                                        <textarea
                                            onChange={this.handleChange}
                                            value={this.state.body}
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

                    <div className="col-md-6">
                        <div className="card">
                            <div className="card-header">Recent tweets</div>
                            
                            <div className="card-body">
                            {!this.state.loading ? this.renderPosts() : 'Loading'}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default App;
