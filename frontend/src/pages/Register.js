import { useState } from "react";
import api from "../services/api";

export default function Register() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [msg, setMsg] = useState("");

  const submit = async (e) => {
    e.preventDefault();
    try {
      const res = await api.post("register.php", {
        name,
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
      <h2>Register</h2>
      <form onSubmit={submit}>
        <input placeholder="Name" onChange={e => setName(e.target.value)} /><br />
        <input placeholder="Email" onChange={e => setEmail(e.target.value)} /><br />
        <input type="password" placeholder="Password" onChange={e => setPassword(e.target.value)} /><br />
        <button>Register</button>
      </form>
      <p>{msg}</p>
    </div>
  );
}
