import "./App.css";
import { Routes, Route, NavLink } from "react-router-dom";

import Home from "./pages/Home";
import Services from "./pages/Services";
import Contact from "./pages/Contact";
import ServiceDetail from "./pages/ServiceDetail";
import VinChecker from "./pages/VinChecker";

function App() {
  return (
    <>
      <nav>
        <NavLink to="/" end>Home</NavLink> |{" "}
        <NavLink to="/services">Services</NavLink> |{" "}
        <NavLink to="/vin-checker">VIN Checker</NavLink> |{" "}
        <NavLink to="/contact">Contact</NavLink>
      </nav>

      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/services" element={<Services />} />
        <Route path="/services/:serviceName" element={<ServiceDetail />} />
        <Route path="/vin-checker" element={<VinChecker />} />
        <Route path="/contact" element={<Contact />} />
      </Routes>
    </>
  );
}

export default App;