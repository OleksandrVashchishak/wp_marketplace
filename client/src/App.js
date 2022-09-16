import { Routes, Route } from "react-router-dom";
import { GetCars, AddCar, Login, AddPost, TopBar, Registration, Account, Messanger, Media, Posts } from './components'
import React from "react";
import './App.css';

const App = () => {
  const [isLogin, setIsLogin] = React.useState(false);

  React.useEffect(() => {
    localStorage.getItem("token") && setIsLogin(true)
  }, [isLogin]);


  return (
    <div className="App container">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
      <TopBar isLogin={isLogin} setIsLogin={setIsLogin} />

      <Routes>
        <Route path="/" element={<GetCars isLogin={isLogin} />} />
      </Routes>

      {!isLogin && <Routes>
        <Route path="login" element={<Login setIsLogin={setIsLogin} />} />
        <Route path="registration" element={<Registration setIsLogin={setIsLogin} />} />
      </Routes>}

      {isLogin && <Routes>
        <Route path="add-car" element={<AddCar />} />
        <Route path="add-post" element={<AddPost />} />
        <Route path="posts" element={<Posts />} />
        <Route path="account" element={<Account />} />
        <Route path="messanger" element={<Messanger />} />
        <Route path="media" element={<Media />} />
      </Routes>}


    </div>
  );
}

export default App;
