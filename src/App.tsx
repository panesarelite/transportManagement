import React from 'react';
import { Truck, Star, Users, MapPin, Calendar, BarChart3 } from 'lucide-react';

function App() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900">
      {/* Header */}
      <header className="bg-white/10 backdrop-blur-md border-b border-white/20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center py-4">
            <div className="flex items-center space-x-3">
              <Star className="w-8 h-8 text-red-400" fill="currentColor" />
              <div>
                <h1 className="text-2xl font-bold text-white">Captain Dispatch</h1>
                <p className="text-purple-200 text-sm">Professional Transportation Management</p>
              </div>
            </div>
            <nav className="hidden md:flex space-x-6">
              <a href="#features" className="text-white/80 hover:text-white transition-colors">Features</a>
              <a href="#demo" className="text-white/80 hover:text-white transition-colors">Demo</a>
              <a href="#contact" className="text-white/80 hover:text-white transition-colors">Contact</a>
            </nav>
          </div>
        </div>
      </header>

      {/* Hero Section */}
      <section className="relative py-20 px-4">
        <div className="max-w-7xl mx-auto text-center">
          <h2 className="text-5xl md:text-6xl font-bold text-white mb-6">
            Streamline Your
            <span className="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-pink-400"> Dispatch</span>
          </h2>
          <p className="text-xl text-purple-200 mb-8 max-w-3xl mx-auto">
            Complete dispatch management solution designed specifically for Canadian transportation companies. 
            Manage dispatches, track vehicles, and optimize operations with our powerful platform.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <a 
              href="/auth/login.php" 
              className="bg-gradient-to-r from-red-500 to-pink-500 text-white px-8 py-4 rounded-lg font-semibold hover:from-red-600 hover:to-pink-600 transition-all transform hover:scale-105 shadow-lg"
            >
              Access System
            </a>
            <button className="bg-white/10 backdrop-blur-md text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/20 transition-all border border-white/20">
              Watch Demo
            </button>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section id="features" className="py-20 px-4 bg-white/5 backdrop-blur-sm">
        <div className="max-w-7xl mx-auto">
          <div className="text-center mb-16">
            <h3 className="text-4xl font-bold text-white mb-4">Powerful Features</h3>
            <p className="text-purple-200 text-lg">Everything you need to manage your transportation business</p>
          </div>
          
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div className="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all">
              <Truck className="w-12 h-12 text-red-400 mb-4" />
              <h4 className="text-xl font-semibold text-white mb-3">Dispatch Management</h4>
              <p className="text-purple-200">Create, assign, and track dispatches with our intuitive interface. Support for multi-day routes and complex scheduling.</p>
            </div>
            
            <div className="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all">
              <MapPin className="w-12 h-12 text-green-400 mb-4" />
              <h4 className="text-xl font-semibold text-white mb-3">Live Tracking</h4>
              <p className="text-purple-200">Real-time GPS tracking with Google Maps integration. Monitor vehicle locations and optimize routes.</p>
            </div>
            
            <div className="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all">
              <Users className="w-12 h-12 text-blue-400 mb-4" />
              <h4 className="text-xl font-semibold text-white mb-3">Role-Based Access</h4>
              <p className="text-purple-200">Secure multi-role system for admins, dispatchers, drivers, customers, and accountants.</p>
            </div>
            
            <div className="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all">
              <Calendar className="w-12 h-12 text-yellow-400 mb-4" />
              <h4 className="text-xl font-semibold text-white mb-3">Smart Scheduling</h4>
              <p className="text-purple-200">Advanced scheduling with Edmonton timezone support and Canadian transportation regulations.</p>
            </div>
            
            <div className="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all">
              <BarChart3 className="w-12 h-12 text-purple-400 mb-4" />
              <h4 className="text-xl font-semibold text-white mb-3">Analytics & Reports</h4>
              <p className="text-purple-200">Comprehensive reporting with CSV export, performance metrics, and business insights.</p>
            </div>
            
            <div className="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all">
              <Star className="w-12 h-12 text-red-400 mb-4" />
              <h4 className="text-xl font-semibold text-white mb-3">Canadian Focus</h4>
              <p className="text-purple-200">Built for Canadian transportation with dangerous goods classification and reefer support.</p>
            </div>
          </div>
        </div>
      </section>

      {/* Demo Section */}
      <section id="demo" className="py-20 px-4">
        <div className="max-w-7xl mx-auto">
          <div className="text-center mb-16">
            <h3 className="text-4xl font-bold text-white mb-4">Try the Demo</h3>
            <p className="text-purple-200 text-lg">Experience the full system with our demo accounts</p>
          </div>
          
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div className="bg-gradient-to-br from-red-500/20 to-pink-500/20 backdrop-blur-md rounded-xl p-6 border border-red-400/30">
              <div className="text-center">
                <div className="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                  <Users className="w-8 h-8 text-red-400" />
                </div>
                <h4 className="text-lg font-semibold text-white mb-2">Admin</h4>
                <p className="text-sm text-purple-200 mb-4">Full system access</p>
                <div className="text-xs text-purple-300">
                  <p>admin@captaintransport.com</p>
                  <p>admin123</p>
                </div>
              </div>
            </div>
            
            <div className="bg-gradient-to-br from-blue-500/20 to-indigo-500/20 backdrop-blur-md rounded-xl p-6 border border-blue-400/30">
              <div className="text-center">
                <div className="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                  <Truck className="w-8 h-8 text-blue-400" />
                </div>
                <h4 className="text-lg font-semibold text-white mb-2">Dispatcher</h4>
                <p className="text-sm text-purple-200 mb-4">Manage dispatches</p>
                <div className="text-xs text-purple-300">
                  <p>dispatcher@captaintransport.com</p>
                  <p>dispatch123</p>
                </div>
              </div>
            </div>
            
            <div className="bg-gradient-to-br from-green-500/20 to-emerald-500/20 backdrop-blur-md rounded-xl p-6 border border-green-400/30">
              <div className="text-center">
                <div className="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                  <MapPin className="w-8 h-8 text-green-400" />
                </div>
                <h4 className="text-lg font-semibold text-white mb-2">Driver</h4>
                <p className="text-sm text-purple-200 mb-4">Mobile tracking</p>
                <div className="text-xs text-purple-300">
                  <p>driver@captaintransport.com</p>
                  <p>driver123</p>
                </div>
              </div>
            </div>
            
            <div className="bg-gradient-to-br from-yellow-500/20 to-orange-500/20 backdrop-blur-md rounded-xl p-6 border border-yellow-400/30">
              <div className="text-center">
                <div className="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                  <BarChart3 className="w-8 h-8 text-yellow-400" />
                </div>
                <h4 className="text-lg font-semibold text-white mb-2">Customer</h4>
                <p className="text-sm text-purple-200 mb-4">Track shipments</p>
                <div className="text-xs text-purple-300">
                  <p>customer@captaintransport.com</p>
                  <p>customer123</p>
                </div>
              </div>
            </div>
          </div>
          
          <div className="text-center mt-12">
            <a 
              href="/auth/login.php" 
              className="inline-flex items-center bg-gradient-to-r from-red-500 to-pink-500 text-white px-8 py-4 rounded-lg font-semibold hover:from-red-600 hover:to-pink-600 transition-all transform hover:scale-105 shadow-lg"
            >
              <Star className="w-5 h-5 mr-2" />
              Start Demo
            </a>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-black/20 backdrop-blur-md border-t border-white/20 py-12 px-4">
        <div className="max-w-7xl mx-auto">
          <div className="grid md:grid-cols-3 gap-8">
            <div>
              <div className="flex items-center space-x-3 mb-4">
                <Star className="w-6 h-6 text-red-400" fill="currentColor" />
                <span className="text-xl font-bold text-white">Captain Dispatch</span>
              </div>
              <p className="text-purple-200">
                Professional dispatch management for the Canadian transportation industry.
              </p>
            </div>
            
            <div>
              <h4 className="text-lg font-semibold text-white mb-4">Features</h4>
              <ul className="space-y-2 text-purple-200">
                <li>Real-time tracking</li>
                <li>Multi-role access</li>
                <li>Canadian compliance</li>
                <li>Mobile-friendly</li>
              </ul>
            </div>
            
            <div>
              <h4 className="text-lg font-semibold text-white mb-4">Support</h4>
              <ul className="space-y-2 text-purple-200">
                <li>Documentation</li>
                <li>Training</li>
                <li>Technical support</li>
                <li>Custom development</li>
              </ul>
            </div>
          </div>
          
          <div className="border-t border-white/20 mt-8 pt-8 text-center">
            <p className="text-purple-300">
              © 2025 Captain Transport. All rights reserved. | Developed by <strong>PanesarElite</strong>
            </p>
          </div>
        </div>
      </footer>
    </div>
  );
}

export default App;