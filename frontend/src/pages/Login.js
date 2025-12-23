import { useState } from "react";
import api from "../services/api";

export default function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [msg, setMsg] = useState("");

  const submit = async (e) => {
    e.preventDefault();
    try {
      const res = await api.post("login.php", {
        email,
        password,
      });
      setMsg(JSON.stringify(res.data));
    } catch (err) {
      setMsg("Error");
    }
  };

  return (
    <div>
      <h2>Login</h2>
      <form onSubmit={submit}>
        <input placeholder="Email" onChange={e => setEmail(e.target.value)} /><br />
        <input type="password" placeholder="Password" onChange={e => setPassword(e.target.value)} /><br />
        <button>Login</button>
      </form>
      <p>{msg}</p>
    </div>
  );
}
