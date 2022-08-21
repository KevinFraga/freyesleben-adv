import React, { Component } from 'react';
import '../styles/uploader.css';

const axios = require('axios').default;

class Uploader extends Component {
  constructor() {
    super();
    this.state = {
      file: '',
      fileType: 'RG',
      userId: 0,
      role: '',
      name: '',
    };
    this.handleFile = this.handleFile.bind(this);
    this.handleSelect = this.handleSelect.bind(this);
    this.handleUpload = this.handleUpload.bind(this);
  }

  componentDidMount() {
    const token = localStorage.getItem('token');
    const { userId } = this.state;

    if (token && !userId) {
      axios
        .post('http://localhost:3007/user/token', { token })
        .then((response) => {
          const { id, role, name } = response.data;
          this.setState({ userId: id, role, name });
        })
        .catch((_error) => {
          localStorage.removeItem('token');
        });
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
    const { file, fileType, userId, name } = this.state;
    const token = localStorage.getItem('token');

    const formData = new FormData();
    formData.append('fileType', fileType);
    formData.append('userId', userId);
    formData.append('name', name);
    formData.append('token', token);
    formData.append('file', file);

    axios
      .post(`http://localhost:3007/user/${userId}/file/upload`, formData, {
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      })
      .then((response) => {
        alert(response.data.message);
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
    const fileTypes = [
      'RG',
      'CPF',
      'CNH',
      'CTPS',
      'Contrato',
      'Comprovante de Residência',
      'Carta de Aposentadoria',
      'Procuração',
      'Termo de Hipossuficiência',
      'Termo de Renúncia',
    ];
    return (
      <div>
        {this.backlogo()}
        <div className="upload-container">
          <input type="file" onChange={this.handleFile} name="file" />
          <select name="fileType" onChange={this.handleSelect}>
            {fileTypes.map((type) => (
              <option key={type} value={type}>
                {type}
              </option>
            ))}
          </select>
          <button
            type="button"
            className="f-button"
            onClick={this.handleUpload}
          >
            Enviar
          </button>
        </div>
      </div>
    );
  }
}

export default Uploader;
