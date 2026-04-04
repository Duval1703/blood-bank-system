#!/bin/bash
# Quick script to push Blood Bank Management System to GitHub

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║     📤 Pushing Blood Bank Management System to GitHub         ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in a git repository
if [ ! -d ".git" ]; then
    echo -e "${YELLOW}⚠️  Not a git repository. Initializing...${NC}"
    git init
    git remote add origin https://github.com/sipouwaivana-tech/Blood-Bank-Mangement-System-BBMS.git
    echo -e "${GREEN}✓ Git initialized${NC}"
fi

echo -e "${BLUE}📊 Current status:${NC}"
git status --short
echo ""

echo -e "${BLUE}➕ Adding all deployment files...${NC}"
git add .

echo -e "${GREEN}✓ Files added${NC}"
echo ""

echo -e "${BLUE}💬 Creating commit...${NC}"
git commit -m "Add Railway deployment configuration and comprehensive documentation

- Add Procfile, nixpacks.toml, railway.json for Railway deployment
- Add environment templates (.env.railway, .env.production)
- Add comprehensive deployment documentation (50+ KB)
- Add interactive deployment script (deploy.sh)
- Update README with deployment instructions
- Add GitHub push guide
- Ready for production deployment to Railway"

echo ""
echo -e "${GREEN}✓ Changes committed${NC}"
echo ""

echo -e "${BLUE}🚀 Pushing to GitHub...${NC}"
git push origin main

if [ $? -eq 0 ]; then
    echo ""
    echo -e "${GREEN}╔════════════════════════════════════════════════════════════════╗${NC}"
    echo -e "${GREEN}║                    ✅ SUCCESS!                                 ║${NC}"
    echo -e "${GREEN}╚════════════════════════════════════════════════════════════════╝${NC}"
    echo ""
    echo -e "${GREEN}✓ Code pushed to GitHub successfully!${NC}"
    echo ""
    echo -e "${BLUE}🔗 Repository:${NC}"
    echo "   https://github.com/sipouwaivana-tech/Blood-Bank-Mangement-System-BBMS"
    echo ""
    echo -e "${BLUE}🚀 Next Steps:${NC}"
    echo "   1. Go to https://railway.app/new"
    echo "   2. Click 'Deploy from GitHub repo'"
    echo "   3. Select: sipouwaivana-tech/Blood-Bank-Mangement-System-BBMS"
    echo "   4. Add environment variables (see RAILWAY_DEPLOYMENT.md)"
    echo "   5. Deploy!"
    echo ""
    echo -e "${BLUE}📖 Documentation:${NC}"
    echo "   - Quick Start: QUICK_START.md"
    echo "   - Full Guide: RAILWAY_DEPLOYMENT.md"
    echo ""
else
    echo ""
    echo -e "${YELLOW}⚠️  Push failed. Please check the error above.${NC}"
    echo ""
    echo "Common solutions:"
    echo "1. Make sure you're logged in to GitHub"
    echo "2. Use a Personal Access Token for authentication"
    echo "3. Check your internet connection"
    echo ""
    echo "See GITHUB_PUSH_GUIDE.md for detailed troubleshooting"
fi
