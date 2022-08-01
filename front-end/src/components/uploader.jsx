import React, { Component } from 'react';
import '../styles/uploader.css';

const axios = require('axios').default;

class Uploader extends Component {
  constructor() {
    super();
    this.state = {
      loading: true,
      file: '',
      fileType: 'RG',
      loggedIn: false,
      userId: 0,
    };
    this.handleFile = this.handleFile.bind(this);
    this.handleSelect = this.handleSelect.bind(this);
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
    });
  }

  handleSelect({ target }) {
    this.setState({
      fileType: target.value,
    });
  }

  handleUpload() {
    const { file, fileType, userId } = this.state;
    const token = localStorage.getItem('token');
    
    const formData = new FormData();
    formData.append('fileType', fileType);
    formData.append('userId', userId);
    formData.append('token', token);
    formData.append('file', file);
    
    axios
      .post(`http://localhost:3007/user/${userId}/file/upload`, formData, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
      .then((response) => {
        alert(response.data.message);
      })
      .catch((error) => {
        alert(error.response.data.message);
      });
  }

  render() {
    const fileTypes = ['RG', 'CPF', 'CNH', 'CTPS', 'Contrato', 'Comprovante de Residência', 'Carta de Aposentadoria', 'Procuração', 'Termo de Hipossuficiência', 'Termo de Renúncia'];
    return (
      <div>
        <div className="upload-container">
          <input type="file" onChange={this.handleFile} name="file" />
          <select name='fileType' onChange={this.handleSelect}>
            {fileTypes.map((type) => <option key={type} value={type}>{type}</option>)}
          </select>
          <button type="button" onClick={this.handleUpload}>
            Enviar
          </button>
        </div>
      </div>
    );
  }
}

export default Uploader;
