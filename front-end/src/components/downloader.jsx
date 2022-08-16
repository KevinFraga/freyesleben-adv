import React, { Component } from 'react';
import '../styles/login.css';

const axios = require('axios').default;

class Downloader extends Component {
  constructor() {
    super();
    this.state = {
      userId: 0,
      role: '',
    };

    this.handleDownload = this.handleDownload.bind(this);
  }

  componentDidMount() {
    const token = localStorage.getItem('token');
    const { userId } = this.state;

    if (token && !userId) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, role } = response.data;
          this.setState({ userId: id, role });
        })
        .catch((_error) => {
          localStorage.removeItem('token');
        });
    }
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  handleDownload() {
    const { userId } = this.state;

    axios.get(`http://localhost:3007/user/${userId}/file/download/CNH`);
    // .then((response) => {
    //   alert(response.data.message);
    // })
    // .catch((error) => {
    //   alert(error.response.data.message);
    // });
  }

  render() {
    return (
      <div>
        {this.backlogo()}
        <div className="upload-container">
          <button
            type="button"
            className="f-button"
            onClick={this.handleDownload}
          >
            Teste
          </button>
        </div>
      </div>
    );
  }
}

export default Downloader;
