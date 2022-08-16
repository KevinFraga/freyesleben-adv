import React, { Component } from 'react';
import { Navigate } from 'react-router-dom';
import '../styles/login.css';

const axios = require('axios').default;

class FeedbackNew extends Component {
  constructor() {
    super();
    this.state = {
      title: '',
      text: '',
      done: false,
      userId: 0,
      role: '',
    };
    this.handleChange = this.handleChange.bind(this);
    this.submitPost = this.submitPost.bind(this);
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

  handleChange({ target }) {
    this.setState({
      [target.name]: target.value,
    });
  }

  submitPost() {
    const { title, text, userId } = this.state;

    const headers = { title, text, userId };

    axios.post('http://localhost:3007/post/feedback/new', headers).then((_response) => {
      this.setState({ done: true });
    });
  }

  render() {
    const { title, text, done } = this.state;
    return (
      <div className="form login">
        {done && <Navigate to="/depoimentos" />}
        <div className="login-form">
          <label htmlFor="title">Título do Post</label>
          <input
            type="text"
            id="title"
            name="title"
            value={title}
            onChange={this.handleChange}
          />
        </div>
        <div className="login-form">
          <label htmlFor="text">Texto</label>
          <textarea
            id="text"
            name="text"
            value={text}
            onChange={this.handleChange}
          />
        </div>
        <div className="new-user-button-container">
          <button
            type="button"
            onClick={this.submitPost}
            className="button new-user-button"
          >
            Postar
          </button>
        </div>
      </div>
    );
  }
}

export default FeedbackNew;
