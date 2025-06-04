import { BrowserRouter as Router, Routes, Route, Link } from 'react-router';
import Dashboard from './pages/Dashboard';
import Workspaces from './pages/Workspaces';
import Google from './pages/GoogleDashboard.jsx';
import Microsoft from './pages/MicrosoftDashboard.jsx';
import Profile from './pages/Profile';

function App() {
    return (
        <Router>
            <div style={{ display: 'flex' }}>
                {/* Temporary Sidebar nav */}
                <nav style={{ width: '200px' }}>
                    <ul>
                        <li><Link to="/">Dashboard</Link></li>
                        <li><Link to="/workspaces">Workspaces</Link></li>
                        <li><Link to="/google">Google</Link></li>
                        <li><Link to="/microsoft">Microsoft</Link></li>
                        <li><Link to="/profile">Profile</Link></li>
                    </ul>
                </nav>

                {/* Fontent */}
                <main style={{ marginLeft: '20px' }}>
                    <Routes>
                        <Route path="/" element={<Dashboard />} />
                        <Route path="/workspaces" element={<Workspaces />} />
                        <Route path="/google" element={<Google />} />
                        <Route path="/microsoft" element={<Microsoft />} />
                        <Route path="/profile" element={<Profile />} />
                    </Routes>
                </main>
            </div>
        </Router>
    );
}

export default App;
