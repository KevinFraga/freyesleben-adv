import React, { Component } from 'react';
import '../styles/uploader.css';

const axios = require('axios').default;

class Uploader extends Component {
  constructor() {
    super();
    this.state = {
      file: '',
      kind: 'RG',
    };
    this.handleFile = this.handleFile.bind(this);
    this.handleSelect = this.handleSelect.bind(this);
    this.handleUpload = this.handleUpload.bind(this);
  }

  handleFile({ target }) {
    this.setState({
      file: target.files[0],
    });
  }

  handleSelect({ target }) {
    this.setState({
      kind: target.value,
    });
  }

  handleUpload() {
    const { file, kind } = this.state;
    const { userId, name } = this.props;
    const token = localStorage.getItem('token');

    const formData = new FormData();
    formData.append('kind', kind);
    formData.append('contentType', file.type);
    formData.append('extension', file.name.slice(-3));
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

  validateFile() {
    const { file } = this.state;
    let answer = false;

    if (file) {
      if (file.name.slice(-3) === 'pdf' && file.size < 5000000) {
        answer = true;
      }
    }

    return answer;
  }

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
      'Comprovante de Pagamento',
    ];
    return (
      <div>
        {this.backlogo()}
        <div className="upload-container">
          <input type="file" onChange={this.handleFile} name="file" />
          <select name="kind" onChange={this.handleSelect}>
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
            disabled={!this.validateFile()}
          >
            Enviar
          </button>
        </div>
      </div>
    );
  }
}

export default Uploader;
