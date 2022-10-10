import React, { Component } from 'react';
import '../styles/uploader.css';

const axios = require('axios').default;

class ProfilepicUploader extends Component {
  constructor() {
    super();
    this.state = {
      file: '',
      kind: 'profilepic',
    };
    this.handleFile = this.handleFile.bind(this);
    this.handleUpload = this.handleUpload.bind(this);
  }

  handleFile({ target }) {
    this.setState({
      file: target.files[0],
    });
  }

  validateFile() {
    const { file } = this.state;
    let answer = false;

    if (file) {
      if (
        file.name.slice(-3) === 'jpg' ||
        file.name.slice(-3) === 'png' ||
        file.name.slice(-4) === 'jpeg'
      ) {
        answer = true;
      }
    }

    return answer;
  }

  handleUpload() {
    const { file, kind } = this.state;
    const { userId, name } = this.props;
    const token = localStorage.getItem('token');

    const formData = new FormData();
    formData.append('kind', kind);
    formData.append('contentType', file.type);
    formData.append(
      'extension',
      file.name.slice(-4) === 'jpeg' ? file.name.slice(-4) : file.name.slice(-3)
    );
    formData.append('userId', userId);
    formData.append('name', name);
    formData.append('token', token);
    formData.append('file', file);

    axios
      .post(
        `http://localhost:3007/user/${userId}/file/upload/profilepic`,
        formData,
        {
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        }
      )
      .then((response) => {
        alert(response.data.message);
        window.location.reload(false);
      })
      .catch((error) => {
        alert(error.response.data.message);
      });
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  render() {
    return (
      <div>
        {this.backlogo()}
        <div className="upload-container">
          <input type="file" onChange={this.handleFile} name="file" />
          <button
            type="button"
            className="f-button"
            onClick={this.handleUpload}
            disabled={!this.validateFile()}
          >
            Enviar
          </button>
        </div>
      </div>
    );
  }
}

export default ProfilepicUploader;
