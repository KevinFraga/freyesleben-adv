import React from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from './pages/home';
import Login from './pages/login';
import Exclusive from './pages/member_exclusive';
import Success from './pages/success_cases';
import WhoWeAre from './pages/who_we_are';
import Upload from './pages/upload';
import Download from './pages/download';
import Feed from './pages/feed';
import FeedNew from './pages/feedNew';
import Blog from './pages/blog';
import BlogNew from './pages/blogNew';
import Partnerships from './pages/partnerships';
import './styles/app.css';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/login" element={<Login />} />
        <Route path="/membros/:id" element={<Exclusive />} />
        <Route path="/membros/:id/upload" element={<Upload />} />
        <Route path="/membros/:id/download" element={<Download />} />
        <Route path="/causas" element={<Success />} />
        <Route path="/quem_somos" element={<WhoWeAre />} />
        <Route path="/blog" element={<Blog />} />
        <Route path="/blog/novo" element={<BlogNew />} />
        <Route path="/depoimentos" element={<Feed />} />
        <Route path="/depoimentos/novo" element={<FeedNew />} />
        <Route path="/parceiros" element={<Partnerships />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
