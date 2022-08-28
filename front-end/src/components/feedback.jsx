import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import '../styles/curriculum.css';

const axios = require('axios').default;

class Feedback extends Component {
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
      axios.get('http://localhost:3007/post/feedback').then((response) => {
        this.setState({ posts: response.data, loading: false });
      });
    }
  }

  handleDelete({ target }) {
    const postId = target.name;

    axios
      .delete(`http://localhost:3007/post/feedback/${postId}`)
      .then(() => window.location.reload(false));
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    const { posts } = this.state;
    const { userId, role } = this.props;

    const isAdmin = role === 'admin';
    const isEmpty = posts.length === 0;

    return (
      <div>
        {!isEmpty && this.backlogo()}
        <div className="titleBox">
          <p className="title">Depoimentos dos Clientes</p>
          <p className="subtitle">O que andam falando de nós...</p>
          <button className="p-button" type="button">
            <Link to="novo">Novo Depoimento</Link>
          </button>
        </div>
        {posts.map((post) => (
          <div className="post">
            <div className="p-img">
              <p className="p-name">{post.name}</p>
              <img src="/login-removebg-preview.png" alt="user" />
            </div>
            <div className="p-img">
              <p className="p-name">{post.title}</p>
              <p>{post.date}</p>
            </div>
            <div className="p-text">
              <p>{post.text}</p>
            </div>
            {(isAdmin || userId === post.userId) && (
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

export default Feedback;
