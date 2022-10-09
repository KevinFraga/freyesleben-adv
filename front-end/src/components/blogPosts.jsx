import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import '../styles/curriculum.css';

const axios = require('axios').default;

class BlogPosts extends Component {
  constructor() {
    super();
    this.state = {
      posts: [],
      loading: true,
    };
    this.handleDelete = this.handleDelete.bind(this);
  }

  componentDidMount() {
    const { loading } = this.state;

    if (loading) {
      axios.get('http://localhost:3007/post').then((response) => {
        this.setState({ posts: response.data, loading: false });
      });
    }
  }

  handleDelete({ target }) {
    const postId = target.name;

    axios
      .delete(`http://localhost:3007/post/${postId}`)
      .then(() => window.location.reload(false));
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    const { posts, loading } = this.state;
    const { role } = this.props;

    const isAdmin = role === 'admin';
    const isEmpty = posts.length === 0;

    return (
      <div>
        {!isEmpty && this.backlogo()}
        <div className="titleBox">
          <p className="title">Blog do Advogado</p>
          <p className="subtitle">O que penso sobre...</p>
          {isAdmin && (
            <button type="button" className="p-button">
              <Link to="novo">Novo Post</Link>
            </button>
          )}
        </div>
        {!loading &&
          posts.map((post) => (
            <div className="post" key={post.id}>
              <div className="p-img">
                <p className="p-name">{post.name}</p>
                <img src={post.profilepic} alt={post.name} />
              </div>
              <div className="p-img">
                <p className="p-name">{post.title}</p>
                <p>{post.date}</p>
              </div>
              <div className="p-text">
                <p>{post.text}</p>
              </div>
              {isAdmin && (
                <button
                  type="button"
                  className="p-button"
                  name={post.id}
                  onClick={this.handleDelete}
                >
                  Excluir Post
                </button>
              )}
            </div>
          ))}
      </div>
    );
  }
}

export default BlogPosts;
