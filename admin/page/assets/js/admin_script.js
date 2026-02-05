let sidebarCollapsed = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebarCollapsed = !sidebarCollapsed;
            
            if (sidebarCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }
        }

    
        // Function to update page content
        function updatePageContent(page, title, subtitle) {
            const pageHeader = document.querySelector('.page-header');
            const dynamicContent = document.getElementById('dynamicContent');
            
            // Update page title
            pageHeader.innerHTML = `
                <h1 class="page-title">${title}</h1>
                <p class="page-subtitle">${subtitle}</p>
            `;
            
            // Update content
            dynamicContent.innerHTML = pageContent[page] || pageContent.dashboard;
        }

        // Function to handle route changes
        function handleRoute() {
            const hash = window.location.hash.slice(1) || 'dashboard';
            
            // Remove active class from all links
            document.querySelectorAll('.menu-item a').forEach(l => l.classList.remove('active'));
            
            // Add active class to current link
            const currentLink = document.querySelector(`a[href="#${hash}"]`);
            if (currentLink) {
                currentLink.classList.add('active');
            }
            
            // Page mapping with titles and subtitles
            const pageMap = {
                'dashboard': { 
                    key: 'dashboard', 
                    title: 'Dashboard Overview', 
                    subtitle: "Welcome back! Here's what's happening with your platform today." 
                },
                'users': { 
                    key: 'users', 
                    title: 'User Management', 
                    subtitle: 'Manage all user accounts and monitor user activity.' 
                },
                'profiles': { 
                    key: 'profiles', 
                    title: 'User Profiles', 
                    subtitle: 'View and manage user profile information and settings.' 
                },
                'roles': { 
                    key: 'roles', 
                    title: 'Roles & Permissions', 
                    subtitle: 'Configure user roles and manage access permissions.' 
                },
                'posts': { 
                    key: 'posts', 
                    title: 'Content Management', 
                    subtitle: 'Create, edit, and manage all your content and posts.' 
                },
                'pages': { 
                    key: 'posts', 
                    title: 'Page Management', 
                    subtitle: 'Manage static pages and website content.' 
                },
                'comments': { 
                    key: 'posts', 
                    title: 'Comment Management', 
                    subtitle: 'Moderate and manage user comments and feedback.' 
                },
                'orders': { 
                    key: 'orders', 
                    title: 'Order Management', 
                    subtitle: 'Process orders, manage shipments, and handle customer requests.' 
                },
                'products': { 
                    key: 'products', 
                    title: 'Product Catalog', 
                    subtitle: 'Manage your product inventory, pricing, and catalog.' 
                },
                'payments': { 
                    key: 'orders', 
                    title: 'Payment Management', 
                    subtitle: 'Monitor transactions, process refunds, and manage payment methods.' 
                },
                'reports': { 
                    key: 'reports', 
                    title: 'Analytics & Reports', 
                    subtitle: 'Generate insights and track your platform performance.' 
                },
                'marketing': { 
                    key: 'reports', 
                    title: 'Marketing Analytics', 
                    subtitle: 'Track marketing campaigns and customer acquisition metrics.' 
                },
                'settings': { 
                    key: 'settings', 
                    title: 'System Settings', 
                    subtitle: 'Configure platform settings and system preferences.' 
                },
                'tools': { 
                    key: 'settings', 
                    title: 'Admin Tools', 
                    subtitle: 'Access administrative tools and system utilities.' 
                },
                'logout': {
                    key: 'settings',
                    title: 'Logout',
                    subtitle: 'Thank you for using our admin panel.'
                }
            };
            
            const pageInfo = pageMap[hash] || pageMap.dashboard;
            updatePageContent(pageInfo.key, pageInfo.title, pageInfo.subtitle);
            
            // Update page title in browser tab
            document.title = `${pageInfo.title} - Admin Dashboard`;
        }

        // Listen for hash changes
        window.addEventListener('hashchange', handleRoute);
        
        // Handle initial load
        window.addEventListener('load', handleRoute);

        // Handle responsive behavior
        function handleResize() {
            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.add('collapsed');
                document.getElementById('mainContent').classList.add('expanded');
                sidebarCollapsed = true;
            } else if (!sidebarCollapsed) {
                document.getElementById('sidebar').classList.remove('collapsed');
                document.getElementById('mainContent').classList.remove('expanded');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Call on page load