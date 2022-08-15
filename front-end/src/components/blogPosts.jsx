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
      userId: 0,
      role: '',
    };
    this.handleDelete = this.handleDelete.bind(this);
  }

  componentDidMount() {
    const token = localStorage.getItem('token');
    const { userId, loading } = this.state;

    if (loading) {
      axios.get('http://localhost:3007/post').then((response) => {
        this.setState({ posts: response.data, loading: false });
      });
    }

    if (token && !userId) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, name, role } = response.data;
          this.setState({ name, userId: id, role });
        })
        .catch((_error) => {
          localStorage.removeItem('token');
        });
    }
  }

  handleDelete({ target }) {
    const postId = target.name;

    axios
      .delete(`http://localhost:3007/post/${postId}`)
      .then(() => window.location.reload(false));
  }

  render() {
    const { posts, role } = this.state;
    const isAdmin = role === 'admin';
    return (
      <div>
        <div className="titleBox">
          <p className="title">BLOG DO ADVOGADO</p>
          <p className="subtitle">O que penso sobre...</p>
          {isAdmin && <Link to="novo">Novo Post</Link>}
        </div>
        {posts.map((post) => (
          <div className="post">
            <div className="p-img">
              <p className="p-name">Alexandre Guerrieri Freyesleben</p>
              <img src="/Alexandre_sem_fundo.png" alt="alexandre" />
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
                className="p-delete"
                name={post.id}
                onClick={this.handleDelete}
              >
                X
              </button>
            )}
          </div>
        ))}
      </div>
    );
  }
}

export default BlogPosts;
