import React, { Component } from 'react';
import '../styles/uploader.css';

const axios = require('axios').default;

class Uploader extends Component {
  constructor() {
    super();
    this.state = {
      loading: true,
      file: '',
      fileName: '',
      loggedIn: false,
      userId: 0,
    };
    this.handleFile = this.handleFile.bind(this);
    this.handleUpload = this.handleUpload.bind(this);
  }

  componentDidMount() {
    const token = localStorage.getItem('token');

    if (token) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id } = response.data;
          this.setState({ userId: id, loggedIn: true, loading: false });
        })
        .catch((_error) => {
          localStorage.removeItem('token');
          this.setState({ loggedIn: false, loading: false });
        });
    } else {
      this.setState({ loggedIn: false, loading: false });
    }
  }

  handleFile({ target }) {
    this.setState({
      file: target.files[0],
      fileName: target.files[0].name,
    });
  }

  handleUpload() {
    const { file, fileName, userId } = this.state;
    const formData = new FormData();
    formData.append("file", file);
    formData.append("fileName", fileName);

    axios
      .post(`http://localhost:3007/user/${userId}/file/upload`, formData)
      .then((response) => {
        alert(response.data.message);
      })
      .catch((error) => {
        alert(error.response.data.message);
      });
  }

  render() {
    return (
      <div>
        <div className="upload-container">
          <input type="file" onChange={this.handleFile} />
        </div>
      </div>
    );
  }
}

export default Uploader;
