import React, { Component } from 'react';
import '../styles/uploader.css';

const axios = require('axios').default;

class Downloader extends Component {
  constructor() {
    super();
    this.state = {
      files: [],
      loading: true,
    };

    this.handleDownload = this.handleDownload.bind(this);
  }

  componentDidMount() {
    const { userId } = this.props;

    axios
      .get(`http://localhost:3007/user/${userId}/file/download`)
      .then((response) => {
        this.setState({ files: response.data, loading: false });
      });
  }

  backlogo = () => (
    <div className="backlogo-container">
      <img src="/logo.png" alt="logo" />
    </div>
  );

  handleDownload({ target }) {
    const { userId } = this.props;

    window.open(
      `http://localhost:3007/user/${userId}/file/download/${target.name}`
    );
  }

  render() {
    const { files, loading } = this.state;
    return (
      <div>
        {this.backlogo()}
        <div className="upload-container">
          {!loading &&
            files.map((file) => (
              <div key={file.name} className="download-container">
                <div className="d-text">
                  <p>{file.name}</p>
                </div>
                <button
                  type="button"
                  className="d-button"
                  name={file.kind}
                  onClick={this.handleDownload}
                >
                  Download
                </button>
              </div>
            ))}
        </div>
      </div>
    );
  }
}

export default Downloader;
