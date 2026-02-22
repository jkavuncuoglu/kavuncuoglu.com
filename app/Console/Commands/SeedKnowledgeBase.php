<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Neuron\ChatAssistant;
use Illuminate\Console\Command;
use NeuronAI\RAG\Document as RAGDocument;

class SeedKnowledgeBase extends Command
{
    protected $signature = 'kb:seed {--fresh : Clear existing documents before seeding}';

    protected $description = 'Seed the knowledge base with work experience and project documents';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            $this->info('Clearing existing documents...');
            Document::truncate();
        }

        $this->info('Seeding knowledge base...');

        $documents = $this->getDocuments();
        $assistant = ChatAssistant::make();
        $embeddingsProvider = $assistant->getEmbeddingsProvider();

        $bar = $this->output->createProgressBar(count($documents));
        $bar->start();

        foreach ($documents as $doc) {
            $embedding = $embeddingsProvider->embedText($doc['content']);

            Document::create([
                'title' => $doc['title'],
                'type' => $doc['type'],
                'content' => $doc['content'],
                'embedding' => $embedding,
                'chunk_index' => $doc['chunk_index'] ?? 0,
                'source' => $doc['source'] ?? null,
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Knowledge base seeded successfully with ' . count($documents) . ' documents.');

        return Command::SUCCESS;
    }

    protected function getDocuments(): array
    {
        return [
            // Bio documents
            [
                'title' => 'About Jeremy Kavuncuoglu',
                'type' => 'bio',
                'content' => <<<EOT
Jeremy Kavuncuoglu is a talented software engineer with expertise in full-stack web development. He has extensive experience building modern web applications using popular technologies such as Laravel, Vue.js, React, and TypeScript. With his passion for clean code, software architecture, and creating exceptional user experiences, Jeremy is well-equipped to tackle complex projects. He enjoys working on challenging problems and continuously learning new technologies. He's committed to delivering high-quality solutions that meet the needs of users.
EOT,
                'source' => 'bio',
            ],
            [
                'title' => 'Jeremy Background',
                'type' => 'bio',
                'content' => <<<EOT
Jeremy Kavuncuoglu is a professional software engineer focused on building web applications and digital products. He combines technical expertise with a user-centered approach to development. Jeremy has worked on various projects ranging from small business websites to enterprise-level applications. His experience spans both startup environments and larger organizations, giving him versatility in adapting to different team sizes and project requirements.
EOT,
                'source' => 'bio',
                'chunk_index' => 1,
            ],

            // Technical Skills - Backend
            [
                'title' => 'Backend Development Skills',
                'type' => 'skills',
                'content' => <<<EOT
Jeremy's backend development expertise includes:

PHP & Laravel: Jeremy is highly proficient in PHP and the Laravel framework. He builds RESTful APIs, implements authentication systems, creates Eloquent models with complex relationships, writes database migrations, and develops artisan commands. He follows Laravel best practices including service classes, repositories, and proper use of queues and jobs.

Node.js: Jeremy has experience building server-side JavaScript applications, including Express.js APIs and real-time applications with Socket.io.

Python: Jeremy uses Python for scripting, automation, data processing, and building APIs with Flask or FastAPI.

Database Design: Jeremy designs efficient database schemas, writes optimized queries, and implements caching strategies for performance.
EOT,
                'source' => 'skills-backend',
            ],

            // Technical Skills - Frontend
            [
                'title' => 'Frontend Development Skills',
                'type' => 'skills',
                'content' => <<<EOT
Jeremy's frontend development expertise includes:

Vue.js: Jeremy builds reactive single-page applications with Vue 3 using the Composition API. He creates reusable components, manages state with Pinia or Vuex, and implements routing with Vue Router. He's experienced with Vue ecosystem tools like Vite, Vitest, and Vue DevTools.

React: Jeremy develops React applications using functional components and hooks. He manages state with Redux or Context API and implements server-side rendering with Next.js when needed.

TypeScript: Jeremy writes type-safe JavaScript code, defines interfaces and types, and integrates TypeScript with Vue and React projects for improved code quality and developer experience.

CSS & Tailwind: Jeremy creates responsive, accessible interfaces using Tailwind CSS, and is comfortable with traditional CSS, Sass, and CSS-in-JS solutions.
EOT,
                'source' => 'skills-frontend',
            ],

            // Technical Skills - DevOps & Infrastructure
            [
                'title' => 'DevOps and Infrastructure Skills',
                'type' => 'skills',
                'content' => <<<EOT
Jeremy's DevOps and infrastructure skills include:

Docker: Jeremy containerizes applications using Docker and Docker Compose. He creates efficient Dockerfiles, manages multi-container applications, and uses Docker for local development with Laravel Sail.

Git & Version Control: Jeremy is proficient with Git workflows including feature branches, pull requests, code reviews, and managing merge conflicts. He uses GitHub and GitLab for collaboration.

CI/CD: Jeremy sets up continuous integration and deployment pipelines using GitHub Actions, GitLab CI, or Jenkins. He automates testing, building, and deployment processes.

Linux & Server Administration: Jeremy is comfortable with Linux command line, server configuration, SSH, and basic system administration tasks.

Cloud Platforms: Jeremy deploys and manages applications on AWS (EC2, S3, RDS, Lambda) and DigitalOcean (Droplets, Spaces, Managed Databases).
EOT,
                'source' => 'skills-devops',
            ],

            // Technical Skills - AI/ML
            [
                'title' => 'AI and Machine Learning Integration',
                'type' => 'skills',
                'content' => <<<EOT
Jeremy has experience integrating AI and machine learning capabilities into web applications:

Large Language Models (LLMs): Jeremy integrates LLMs like GPT, Claude, and Ollama into applications for natural language processing, content generation, and conversational AI.

RAG Systems: Jeremy builds Retrieval-Augmented Generation systems that combine vector databases with LLMs to provide context-aware responses based on custom knowledge bases.

Embeddings & Vector Search: Jeremy implements text embeddings and similarity search for semantic search, recommendations, and document retrieval.

AI APIs: Jeremy integrates various AI services including OpenAI API, Anthropic Claude API, and self-hosted models using Ollama for private, local AI inference.

This very website features an AI chat assistant built by Jeremy using Laravel, Vue.js, NeuronAI, and Ollama with RAG capabilities.
EOT,
                'source' => 'skills-ai',
            ],

            // Work Philosophy
            [
                'title' => 'Work Philosophy and Values',
                'type' => 'philosophy',
                'content' => <<<EOT
Jeremy believes in writing clean, maintainable code that solves real problems. His core values include:

Code Quality: Jeremy prioritizes writing readable, well-tested code over quick fixes. He believes that investing time in quality upfront saves significant time in maintenance and debugging later.

Clear Communication: Jeremy values clear documentation, meaningful commit messages, and open communication with team members and stakeholders.

Continuous Learning: Technology evolves rapidly, and Jeremy stays current by learning new tools, reading technical blogs, and experimenting with emerging technologies.

Collaboration: Jeremy enjoys working with others, sharing knowledge, and learning from teammates. He believes the best software is built by teams that communicate well.

User Focus: Jeremy keeps end users in mind throughout development, ensuring that technical decisions serve the goal of creating useful, enjoyable products.
EOT,
                'source' => 'philosophy',
            ],

            // Development Approach
            [
                'title' => 'Development Approach',
                'type' => 'philosophy',
                'content' => <<<EOT
Jeremy follows a thoughtful approach to software development:

Planning Before Coding: Jeremy takes time to understand requirements, consider edge cases, and plan the architecture before writing code. This prevents costly rewrites and ensures a solid foundation.

Iterative Development: Jeremy breaks large features into smaller, deliverable increments. This allows for early feedback, reduces risk, and maintains momentum.

Testing: Jeremy writes tests for critical functionality, including unit tests for business logic and integration tests for API endpoints. He uses PHPUnit for Laravel testing and Vitest for Vue.js.

Code Reviews: Jeremy values code reviews as a learning opportunity and quality gate. He provides constructive feedback and appreciates receiving suggestions for improvement.

Refactoring: Jeremy regularly improves existing code, paying down technical debt incrementally rather than letting it accumulate.
EOT,
                'source' => 'approach',
            ],

            // Project Experience - Personal Website
            [
                'title' => 'Personal Website Project',
                'type' => 'project',
                'content' => <<<EOT
Jeremy's Personal Website (This Site):

This website showcases Jeremy's skills and serves as a portfolio and contact point. Key features include:

Technology Stack: Built with Laravel as the backend framework, Vue.js 3 with TypeScript for the frontend, Tailwind CSS for styling, and Inertia.js for seamless SPA navigation.

AI Chat Assistant: The site features an AI-powered chat where visitors can ask questions about Jeremy's experience. It uses Ollama for local LLM inference and implements RAG (Retrieval-Augmented Generation) to provide accurate, contextual responses.

Modern Development: The project uses Docker (Laravel Sail) for local development, ensuring consistent environments. It follows Laravel and Vue.js best practices throughout.

This project demonstrates Jeremy's full-stack capabilities, from database design and API development to interactive frontend components and AI integration.
EOT,
                'source' => 'project-website',
            ],

            // FAQ - General
            [
                'title' => 'Frequently Asked Questions - General',
                'type' => 'faq',
                'content' => <<<EOT
Common questions about Jeremy:

Q: What type of projects does Jeremy work on?
A: Jeremy works on full-stack web applications, from small business websites to complex enterprise systems. He enjoys projects that involve interesting technical challenges and have meaningful impact for users.

Q: What is Jeremy's preferred technology stack?
A: Jeremy's preferred stack is Laravel for the backend and Vue.js with TypeScript for the frontend, styled with Tailwind CSS. However, he's adaptable and works with various technologies based on project requirements.

Q: Is Jeremy available for freelance or consulting work?
A: Jeremy is open to discussing new opportunities, including freelance projects, consulting engagements, and full-time positions. Feel free to reach out through the website.

Q: Where is Jeremy located?
A: Jeremy can work remotely and is flexible with time zones. He's experienced with distributed teams and asynchronous communication.
EOT,
                'source' => 'faq-general',
            ],

            // FAQ - Technical
            [
                'title' => 'Frequently Asked Questions - Technical',
                'type' => 'faq',
                'content' => <<<EOT
Technical questions about Jeremy's work:

Q: Does Jeremy do frontend, backend, or both?
A: Jeremy is a full-stack developer comfortable with both frontend and backend development. He can work across the entire stack or focus on one area depending on team needs.

Q: What databases has Jeremy worked with?
A: Jeremy has experience with MySQL, PostgreSQL, SQLite, and Redis. He can design efficient database schemas, write optimized queries, and implement caching strategies.

Q: Does Jeremy have experience with testing?
A: Yes, Jeremy writes tests using PHPUnit for Laravel backend testing and Vitest/Jest for frontend JavaScript testing. He believes in testing critical business logic and API endpoints.

Q: Can Jeremy work with existing codebases?
A: Absolutely. Jeremy is experienced in reading, understanding, and contributing to existing codebases. He approaches legacy code with care, making incremental improvements while maintaining stability.
EOT,
                'source' => 'faq-technical',
            ],

            // Contact Information
            [
                'title' => 'Contact Information',
                'type' => 'contact',
                'content' => <<<EOT
If you'd like to connect with Jeremy or learn more about his work, you can reach out through his personal website. He is open to discussing:

- New job opportunities and full-time positions
- Freelance and consulting projects
- Collaboration on interesting technical projects
- General questions about his work and experience

Jeremy responds to messages promptly and looks forward to connecting with potential collaborators, employers, and fellow developers.
EOT,
                'source' => 'contact',
            ],
            [
                'title' => 'Jeremy Kavuncuoglu - Professional Bio',
                'type' => 'bio',
                'content' => <<<EOT
Jeremy Kavuncuoglu is a Senior Full-Stack Developer and Cloud Consultant specializing in Laravel, Vue.js, AWS, and Amazon Connect.
He builds scalable, serverless, and high-converting applications with a strong focus on cloud-native architecture.

Jeremy combines deep backend engineering expertise with DevOps automation and AWS serverless infrastructure including Lambda, API Gateway, CodePipeline, CodeBuild, CloudFormation, and Auto Scaling.
He works with businesses that require high-trust consulting, production-grade systems, and performance-optimized web applications.

He is building a personal brand focused on Amazon Connect engineering and Laravel cloud solutions with a target annual income of $160,000 through consulting and product development.
EOT,
                'source' => 'jeremy-bio-2026',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Core Technical Skills',
                'type' => 'skills',
                'content' => <<<EOT
Primary Stack:
- Laravel (API development, authentication, Horizon, queues, scalable architecture)
- Vue.js (SPA applications, modern frontend workflows)
- PHP (advanced backend systems)
- Kotlin (Android development with Jetpack Compose)
- Flutter (cross-platform mobile development)
- React Native (mobile app development)

Cloud & DevOps:
- AWS Lambda (serverless applications)
- AWS CloudFormation (infrastructure as code)
- AWS CodePipeline & CodeBuild (CI/CD automation)
- AWS Auto Scaling & EC2
- Amazon Connect (contact center integrations, Streams API)
- Nginx performance tuning and rate limiting
- Terraform (AWS provider v5 experience)
- Linux (Ubuntu 24.04 optimized development environments)
- Zsh + Powerlevel10k developer tooling

Databases & Infrastructure:
- MySQL
- Redis (SSL configuration, Horizon)
- MongoDB
- VPC design with NAT & private subnets
- SSM, IAM, deployment automation
EOT,
                'source' => 'jeremy-core-skills',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Amazon Connect Specialization',
                'type' => 'expertise',
                'content' => <<<EOT
Jeremy specializes in Amazon Connect consulting, engineering, and custom integrations.

Focus Areas:
- Amazon Connect Streams API development
- Custom CCP (Contact Control Panel) integrations
- Call routing logic and queue optimization
- Lambda-powered contact flows
- CRM integrations with Laravel backends
- Cloud-native telephony automation

He is actively deepening expertise in Streams API from scratch to advanced implementations, positioning himself as a high-trust Amazon Connect consultant.

Goal: Establish authority in Amazon Connect + Laravel integrations and build recurring consulting revenue.
EOT,
                'source' => 'jeremy-amazon-connect-focus',
                'chunk_index' => 0,
            ],

            [
                'title' => 'LoanShield Application',
                'type' => 'project',
                'content' => <<<EOT
LoanShield is a consumer-protection focused mobile application built with Flutter targeting iOS, Android, and Web.

Backend:
- Laravel API for authentication and loan processing
- VIN scanning via barcode or ML text recognition
- Loan-to-value calculations
- Scam detection logic
- Maintenance cost estimation
- Community dealer ratings
- Legal rights education for borrowers

The mission of LoanShield is to help users avoid going underwater on auto, housing, and personal loans by providing transparency and intelligent analysis tools.

LoanShield separates business strategy and technical implementation into distinct workflows for clarity and scalability.
EOT,
                'source' => 'project-loanshield-overview',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Development Environment Setup',
                'type' => 'workflow',
                'content' => <<<EOT
Jeremy uses Ubuntu 24.04 as his primary development environment optimized for Laravel, React Native, and cloud engineering.

Environment includes:
- Zsh shell
- Powerlevel10k theme
- Productivity-focused shell extensions
- Nginx configuration optimization
- Local and AWS deployment workflows
- Composer automation
- Secure Redis and SSL configurations
- CI/CD via AWS CLI and infrastructure as code

He focuses heavily on reproducible environments, deployment automation, and performance tuning.
EOT,
                'source' => 'jeremy-dev-environment-ubuntu',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Business & Personal Branding Strategy',
                'type' => 'business',
                'content' => <<<EOT
Jeremy is building a consulting brand centered on Laravel cloud engineering and Amazon Connect implementation.

Objectives:
- Achieve $160,000+ annual income
- Generate organic authority within 6 months
- Focus on high-trust consulting engagements
- Attract niche AWS + Amazon Connect clients
- Position himself as a business entity rather than a freelance developer

Strategy includes:
- Authority-driven GitHub presence
- Technical thought leadership
- Upwork optimization for Laravel and cloud projects
- High-conversion consulting website
- Long-term recurring consulting revenue

He aims to differentiate through deep AWS serverless expertise combined with practical business-driven engineering solutions.
EOT,
                'source' => 'jeremy-brand-strategy-2026',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Health & Performance Awareness',
                'type' => 'personal',
                'content' => <<<EOT
Jeremy monitors health metrics including blood pressure, hemoglobin levels, and RBC counts.

He uses Galaxy Watch 6 with Samsung Health tracking enabled for blood pressure monitoring.

The focus is on performance optimization, long-term health, and maintaining high cognitive output while building consulting and software products.

Health awareness is treated as part of overall productivity and sustainability.
EOT,
                'source' => 'jeremy-health-performance',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Work Experience – Pleio Inc (2025) – Senior Engineer / Platform Owner',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy served in a senior-level engineering role at Pleio Inc in 2025 with full ownership of AWS infrastructure, DevOps, and platform architecture.

Scope of Responsibility:
- Sole manager of AWS infrastructure (EC2, ASG, IAM, VPC, NAT, Route Tables, Security Groups)
- Amazon Connect environment ownership
- Lambda application development and automation
- Infrastructure cost optimization and reliability improvements
- Production stability and deployment oversight

Key Achievements:
- Delivered GSM v2 and Softphone CCP v2
- Reduced infrastructure costs by approximately $30,000 annually
- Improved deployment safety and reliability
- Strengthened system security posture
- Increased platform scalability through architectural refactoring

This role extended beyond traditional senior development into infrastructure ownership, systems architecture, and operational leadership.
EOT,
                'source' => 'experience-pleio-2025-overview',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Work Experience – AWS Infrastructure & DevOps Ownership',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy acted as the sole AWS infrastructure owner, managing production cloud systems end-to-end.

Infrastructure Managed:
- EC2 instances and Auto Scaling Groups
- Route tables, NAT gateways (regional to zonal migration)
- VPC peering and subnet architecture
- Security groups and IAM roles
- SSM endpoints and instance metadata configuration
- CloudFormation deployments

DevOps Implementations:
- Designed AWS-native CI/CD pipelines using CodePipeline, CodeBuild, and CodeDeploy
- Implemented blue/green deployment patterns
- Automated AMI baking via Packer
- Managed SSM parameter rotation during deployments
- Implemented canary deployment strategy using two-stage CodeDeploy approach

Operational Improvements:
- Cleaned orphaned route tables and NAT resources
- Migrated to zonal NAT gateways for high availability
- Enforced IMDSv2 and instance metadata security
- Ensured all instances were SSM Online
- Reduced downtime risk with infrastructure-as-code practices

Focus: production-safe deployments, automation, zero-downtime rollouts, and infrastructure reliability.
EOT,
                'source' => 'experience-aws-devops-ownership',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Work Experience – Communication Platform Modernization',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy modernized core communication systems, leading development of GSM v2 and Softphone CCP v2.

Architecture & Design:
- Designed provider-agnostic softphone architecture
- Supported Amazon Connect, Twilio, and 8x8 integrations
- Built reusable modular components for scalability

UI/UX Modernization:
- Refactored Call Recordings view with modal-based detail system
- Created reusable AudioPlayer component
- Redesigned navigation and profile management using TailwindCSS
- Implemented modern modal-based UI patterns

Infrastructure Integration:
- Migrated voicemail systems to Amazon Connect
- Built Lambda automations for notifications and queue monitoring
- Enhanced reporting and AI analytics integration (Ollie 3)

Outcome:
Improved maintainability, scalability, vendor flexibility, and overall user experience across the communications platform.
EOT,
                'source' => 'experience-communication-modernization',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Work Experience – Backend Performance Optimization',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy significantly optimized backend job processing and queue systems.

Registration Retry Optimization:
- Refactored Registration Retry job architecture
- Introduced batching to reduce CPU and memory spikes
- Reduced execution time from up to 30 minutes to milliseconds
- Implemented Redis locking for concurrency protection
- Segmented retry processing by program and pharmacy groups
- Added execution monitoring and runtime logging

Queue & Worker Improvements (2026):
- Setup batch processing
- Optimized queue workers for reliability and throughput

Impact:
- Stabilized system performance under load
- Reduced infrastructure strain
- Improved operational predictability and reliability
- Strengthened monitoring and failure handling

This work directly improved system scalability and reduced operational risk.
EOT,
                'source' => 'experience-backend-performance-optimization',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Work Experience – Security Hardening & Compliance',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy implemented multiple layers of application and infrastructure security improvements.

Frontend Security:
- Implemented Content Security Policy (CSP)
- Added Subresource Integrity (SRI)
- Hardened Nginx configuration with strict rate limiting
- Applied login endpoint throttling and brute-force mitigation

Backend & Infrastructure Security:
- Enforced IMDSv2 for EC2 instances
- Managed IAM roles with least-privilege design
- Secured Redis connections with SSL/TLS debugging and validation
- Improved logging and observability
- Denied access to sensitive server files (.env, .git, logs)

Compliance & Testing:
- Developed Business Continuity and Disaster Recovery (BCDR) test documentation outline
- Structured DR testing around RTO, RPO, MTD objectives
- Aligned documentation with NIST SP 800-34, ISO 22301, and SOC 2 practices

Outcome:
Reduced attack surface, improved compliance readiness, and enhanced operational security posture.
EOT,
                'source' => 'experience-security-hardening',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Work Experience – Terraform & Infrastructure as Code',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy designed and maintained production Terraform modules to manage CI/CD and infrastructure.

Terraform Modules Built:
- IAM module (pipeline, CodeBuild, CodeDeploy, Packer roles)
- CodeDeploy module (application, deployment configs, deployment group)
- Pipeline module (SNS, SSM parameters, CodeBuild projects, CodePipeline stages)

Advanced Deployment Architecture:
- Two-stage CodeDeploy strategy (canary + full promote)
- Automated blue ASG termination and target group cleanup
- Dynamic SSM parameter rotation per deployment
- ContinueDeployment integration during promote stage

Migration Work:
- Resolved breaking changes in Terraform AWS Provider v5
- Refactored deprecated arguments
- Managed provider version pinning strategy

Focus:
Forward-compatible infrastructure code, repeatable deployments, and production-safe automation across environments.
EOT,
                'source' => 'experience-terraform-iac',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Work Experience – Pleio Inc – Senior Engineer & AWS Platform Owner (Comprehensive Overview)',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy served as a Senior Engineer and de facto AWS Platform Owner at Pleio Inc, operating far beyond a traditional senior developer role. His responsibilities spanned backend engineering, cloud infrastructure ownership, DevOps automation, communications platform architecture, performance optimization, and security hardening.

Role Scope:
- Sole owner of AWS infrastructure across development, staging, and production
- Architect and implementer of CI/CD systems
- Lead engineer for communication platform modernization
- Backend performance optimization specialist
- Security and compliance contributor
- Operational reliability and cost optimization driver

Cloud & Infrastructure Ownership:
Jeremy managed the entire AWS footprint, including:
- EC2 instances and Auto Scaling Groups (ASGs)
- Launch Templates and version management
- Route tables, NAT gateways (regional to zonal migration)
- VPC peering configurations
- Security Groups and IAM policies
- SSM endpoints and private instance access
- Instance metadata configuration (IMDSv2 enforcement)
- CloudWatch logging and monitoring

He diagnosed and resolved:
- Route table misassociations
- NAT misconfiguration
- MongoDB and Redis connectivity issues
- Security group CIDR corrections
- Orphaned route table cleanup
- SSM endpoint misconfiguration causing offline instances

Deployment & CI/CD Architecture:
Jeremy designed and maintained AWS-native CI/CD pipelines using:
- CodePipeline
- CodeBuild
- CodeDeploy
- Terraform
- Packer

He implemented:
- Blue/Green deployment patterns
- Canary deployments (10% traffic shift with manual approval gate)
- Two-stage CodeDeploy strategy (establish canary → promote via ContinueDeployment)
- Automated AMI baking with Packer
- Launch Template updates during pipeline execution
- Dynamic SSM parameter rotation (current TG, ASG tracking)
- Cleanup stages that terminate old ASGs and delete outdated target groups

He also resolved:
- CloudFormation ROLLBACK_COMPLETE issues
- CAPABILITY_NAMED_IAM deployment requirements
- Terraform AWS provider v5 breaking changes
- Unsupported arguments such as canary_percentage
- CodeDeploy deployment configuration errors

Communication Platform Modernization:
Jeremy led development of GSM v2 and Softphone CCP v2.

Key Architectural Contributions:
- Designed provider-agnostic Softphone architecture
- Integrated Amazon Connect Streams API
- Supported Twilio and 8x8 providers
- Built modular, reusable communication components
- Migrated voicemail infrastructure to Amazon Connect
- Developed Lambda automations for queue monitoring and notifications

Frontend Modernization:
- Refactored Call Recordings view with modal-based detail panels
- Created reusable AudioPlayer component
- Redesigned navigation using TailwindCSS
- Modernized profile management UX
- Improved component consistency and maintainability

Backend Optimization & Queue Engineering:
Jeremy refactored the Registration Retry job architecture.

Original problem:
- Processing time up to 30 minutes
- High CPU usage spikes
- Risk of queue congestion

Solutions:
- Introduced batching strategies
- Implemented Redis locking (30-minute timeout concurrency protection)
- Segmented retry jobs by program group and pharmacy group
- Enforced retry caps and daily processing limits
- Logged execution time and warnings for long runs
- Reduced runtime from minutes to milliseconds

In 2026, he further:
- Implemented batch processing enhancements
- Optimized queue worker configurations
- Improved reliability under production load

Security & Hardening:
Application-level:
- Implemented Content Security Policy (CSP)
- Implemented Subresource Integrity (SRI)
- Hardened login endpoints with stricter rate limiting
- Layered brute-force protections (Nginx + application-level lockout)

Infrastructure-level:
- Enforced IMDSv2
- Hardened PHP-FPM configuration
- Denied access to sensitive files (.env, .git, composer files)
- Implemented strict CORS handling
- Improved observability and logging practices

Compliance & DR Planning:
Jeremy created structured Business Continuity and Disaster Recovery documentation aligned with:
- RTO / RPO objectives
- Disaster scenario simulation
- Recovery validation testing
- NIST SP 800-34 guidance
- ISO 22301 alignment
- SOC 2 operational expectations

Cost & Operational Impact:
- ~$30,000/year infrastructure savings
- Reduced downtime risk
- Reduced deployment failure risk
- Increased platform scalability
- Improved production reliability

This role demonstrates strong ownership, architectural thinking, DevOps maturity, and production-scale system responsibility.
EOT,
                'source' => 'experience-pleio-senior-engineer-comprehensive',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Advanced AWS Networking & Private Infrastructure Engineering',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy engineered and stabilized complex AWS networking configurations across multiple VPCs and environments.

Networking Components Managed:
- VPC peering connections
- Private and public subnets
- Zonal NAT gateways (migration from single regional NAT)
- Route table cleanup and association correction
- Security group CIDR normalization
- SSM VPC endpoints (ec2messages, ssmmessages)
- Private instance SSM-only access patterns

He troubleshot:
- MongoDB public vs private routing paths
- Redis cross-VPC connectivity via peering
- Missing route table associations
- Default route table misrouting
- ElastiCache connectivity validation using direct IP testing
- NAT egress path verification

He enforced:
- Principle of least privilege networking
- Segmented environment routing
- Private compute without public IPs
- Instance metadata security
- Controlled internet egress via NAT

Outcome:
Highly stable private AWS infrastructure with predictable routing behavior and minimized attack surface.
EOT,
                'source' => 'experience-aws-networking-private-infrastructure',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Infrastructure as Code & Terraform Module Architecture',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy designed modular Terraform infrastructure for CI/CD and cloud resource management.

Root Infrastructure:
- main.tf (provider and module wiring)
- variables.tf (parameterization strategy)
- outputs.tf (resource exposure)
- terraform.tfvars (environment configuration)

Modules Designed:
1. IAM module
   - Pipeline role
   - CodeBuild role
   - CodeDeploy role
   - Packer instance role

2. CodeDeploy module
   - Application configuration
   - Deployment groups
   - Canary and full deployment configs
   - Instance lifecycle validation hooks

3. Pipeline module
   - SNS notifications
   - SSM parameter management
   - 3 CodeBuild projects
   - 7-stage CodePipeline workflow

Pipeline Stages:
- Source
- Build
- Packer AMI bake
- Canary Deploy
- Manual approval
- Promote (ContinueDeployment)
- Cleanup (terminate blue ASG + delete old TG)

Advanced Logic:
- buildspec-packer.yml dynamically updates Launch Template & ASG
- buildspec-cleanup.yml deletes blue infrastructure post-promotion
- appspec.yml with ValidateService lifecycle hooks
- Health validation scripts (nginx, php-fpm, /health endpoint checks)

Terraform Maintenance:
- Resolved provider v5 schema changes
- Removed unsupported arguments
- Implemented safe migration strategies
- Ensured forward-compatible module patterns

Focus:
Deterministic, reproducible, production-safe infrastructure automation.
EOT,
                'source' => 'experience-terraform-module-architecture-advanced',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Vue Softphone & Amazon Connect Streams Integration',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy architected and implemented a custom Vue.js Softphone using Amazon Connect Streams API.

Objectives:
- Replace default Amazon Connect CCP
- Embed softphone in SPA architecture
- Hydrate CRM data from Laravel backend during live calls
- Maintain secure authentication boundaries

Core Implementation:
- Streams API initialization and event binding
- Agent state management (Available, Offline, ACW)
- Contact lifecycle event listeners (onConnected, onEnded, onRefresh)
- Real-time call handling and outbound dialing
- Secure token exchange patterns
- Nginx reverse proxy considerations for WebRTC traffic

Advanced Features:
- Lambda-driven contact flows
- Queue monitoring automation
- AI-enhanced analytics integration
- Multi-tenant architecture for multiple Connect instances
- Provider-agnostic abstraction layer

Technical Stack:
- Vue.js SPA
- Laravel backend API
- AWS Lambda
- Amazon Connect
- Redis queues

Outcome:
Production-grade softphone deployments with scalable architecture and vendor flexibility.
EOT,
                'source' => 'experience-vue-softphone-amazon-connect-advanced',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Laravel Backend Architecture & Domain Refactoring',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy led significant backend refactoring efforts to modernize and stabilize a large Laravel codebase serving production healthcare communication workflows.

Architectural Improvements:
- Refactored legacy models into clearer domain-driven structures
- Reduced tight coupling between controllers, jobs, and Eloquent models
- Introduced clearer separation of concerns between application services and infrastructure logic
- Standardized validation, error handling, and logging patterns

Queue & Job Engineering:
- Implemented concurrency-safe job processing with Redis locks
- Enforced idempotent job patterns to avoid duplicate side effects
- Segmented heavy workloads into smaller deterministic batches
- Introduced runtime monitoring and threshold warnings
- Reduced long-running jobs from 30+ minutes to milliseconds

Command Bus & Artisan Integration:
- Used parameterized Artisan commands for controlled retry processing
- Passed schedule configuration as runtime options
- Introduced safety validation before execution
- Logged execution duration and structured metadata

Performance Improvements:
- Indexed high-frequency database queries
- Reduced N+1 query patterns
- Stabilized queue throughput during peak load
- Improved memory usage during batch processing

Outcome:
Improved backend scalability, reduced operational risk, and established patterns that support long-term maintainability.
EOT,
                'source' => 'experience-laravel-domain-refactoring',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Production Incident Debugging & Root Cause Analysis',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy regularly handled high-impact production debugging across infrastructure, networking, queue systems, and application layers.

Examples of Issues Diagnosed:
- Redis SSL handshake failures (stream_socket_enable_crypto wrong version number)
- MongoDB connection timeouts due to incorrect routing path
- Route table misassociations causing cross-VPC communication failures
- Security group CIDR misconfigurations blocking internal traffic
- Instances not reporting to SSM due to endpoint misconfiguration
- CloudFormation stacks stuck in ROLLBACK_COMPLETE
- CodeDeploy deployment misconfiguration errors

Debugging Approach:
- Verified network routing using AWS CLI route inspection
- Tested direct IP connectivity with netcat (nc)
- Confirmed VPC peering route propagation
- Inspected instance metadata options
- Audited IAM permissions and role attachments
- Verified Launch Template version drift
- Analyzed queue logs and execution time anomalies

Operational Philosophy:
- Assume nothing; verify every layer (network → instance → service → app)
- Separate infrastructure-level issues from application-level issues
- Use AWS CLI to validate state rather than relying on assumptions
- Document findings for future prevention

Impact:
Reduced incident resolution time, prevented recurring failures, and improved systemic reliability.
EOT,
                'source' => 'experience-production-debugging-root-cause',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Nginx & PHP-FPM Production Optimization',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy optimized Nginx and PHP-FPM for performance, security, and reliability in a high-traffic Laravel production environment.

Nginx Optimizations:
- Configured IP-based rate limiting using limit_req zones
- Implemented stricter throttling on login and authentication endpoints
- Configured wildcard subdomain handling
- Added CORS headers for API endpoints
- Implemented HTTP to HTTPS redirects
- Hardened sensitive file access restrictions (.env, .git, logs)
- Configured WebSocket upgrade handling
- Enabled optional microcaching for anonymous traffic

PHP-FPM Tuning:
- Configured dynamic process manager
- Tuned max_children, spare servers, and max_requests
- Enabled fastcgi_keep_conn
- Disabled expose_php
- Managed socket permissions securely

Security Enhancements:
- Passed CSP nonce via FastCGI parameters
- Suppressed unnecessary headers
- Implemented layered brute-force protection

Outcome:
Improved application responsiveness, reduced attack surface, and stabilized backend performance under concurrent load.
EOT,
                'source' => 'experience-nginx-phpfpm-optimization',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Blue/Green Deployment Strategy & Deployment Safety',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy designed and partially implemented a robust blue/green deployment architecture for zero-downtime production releases.

Deployment Model:
- AMI-based immutable infrastructure
- New Launch Template version created per deployment
- New Auto Scaling Group provisioned as “green”
- Canary traffic shift (10%)
- Manual approval gate
- Promotion using codedeploy continue-deployment
- Automated cleanup of “blue” ASG and target group

Why Two Deployments:
CodeDeploy cannot pause mid-shift for human approval. Jeremy implemented a two-stage pattern:
1. First deployment establishes canary.
2. Second action promotes deployment safely.

Safety Controls:
- ValidateService hook in appspec.yml
- Health checks on nginx, php-fpm, /health endpoint
- Manual approval gate inside CodePipeline
- Automatic rollback on failed validation

Cleanup Automation:
- Identified blue ASG via deployment metadata
- Terminated obsolete ASG
- Deleted unused target group
- Rotated SSM parameters to track current production resources

Impact:
Reduced deployment risk, improved release confidence, and introduced structured rollback capability.
EOT,
                'source' => 'experience-blue-green-deployment-strategy',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Business Continuity & Disaster Recovery Planning',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy developed structured Business Continuity and Disaster Recovery (BCDR) documentation and test frameworks.

Documentation Covered:
- Executive summary and stakeholder overview
- Test objectives and scope
- Recovery Time Objectives (RTO)
- Recovery Point Objectives (RPO)
- Maximum Tolerable Downtime (MTD)
- Scenario simulation design
- Disaster narrative and trigger events
- Recovery step-by-step procedures
- Chronological incident logs
- Communications log and stakeholder notification structure
- Post-test retrospective checklist

Compliance Alignment:
- NIST SP 800-34 Rev. 1
- ISO 22301:2019
- SOC 2 Type II continuity requirements

Operational Improvements:
- Encouraged immediate documentation post-test
- Formalized retrospective and action item tracking
- Created structured improvement loop after DR exercises

Outcome:
Improved organizational resilience and established a repeatable disaster recovery validation framework.
EOT,
                'source' => 'experience-bcdr-planning-framework',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – AI & Automation Integration (Ollie 3 & Lambda)',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy integrated AI and automation capabilities into the communications platform to enhance operational intelligence.

AI Integration:
- Integrated Ollie 3 AI analysis features
- Enhanced reporting and platform intelligence
- Improved analytics interpretation for call data

Lambda Automations:
- Queue monitoring automation
- Notification triggers
- Data exports
- Event-driven background workflows

Automation Philosophy:
- Replace repetitive manual tasks with Lambda-driven workflows
- Ensure event-driven architecture for reliability
- Keep automation modular and observable
- Reduce operational overhead through code

Outcome:
Increased platform intelligence, improved reporting capabilities, and reduced manual operational burden.
EOT,
                'source' => 'experience-ai-lambda-automation',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – AWS CLI Operations & Infrastructure Verification Workflows',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy developed repeatable AWS CLI workflows to validate infrastructure state, debug production issues, and confirm deployment correctness.

Common Operational Commands Used:
- aws ec2 describe-route-tables
- aws ec2 describe-security-groups
- aws autoscaling terminate-instance-in-auto-scaling-group
- aws cloudformation deploy with CAPABILITY_NAMED_IAM
- aws ssm send-command and get-command-invocation
- aws ec2 modify-instance-metadata-options
- aws autoscaling update-auto-scaling-group
- aws ec2 create-launch-template-version

Verification Patterns:
- Confirmed CIDR corrections in security groups (e.g., MongoDB port 27017 rules)
- Verified route propagation for VPC peering connections
- Audited NAT gateway routing targets
- Inspected ASG associations and Launch Template versions
- Queried CodePipeline and CodeDeploy state via CLI
- Retrieved pipeline, build, and deployment configurations in JSON format

Infrastructure Hygiene:
- Identified and removed orphaned route tables
- Verified subnet associations explicitly
- Confirmed SSM endpoint deployment across all subnets
- Validated route targets (NAT vs Peering vs Local)

Operational Philosophy:
Always verify the actual AWS state instead of assuming configuration correctness.

Impact:
Reduced misconfiguration risk and improved infrastructure transparency during incident response.
EOT,
                'source' => 'experience-aws-cli-operations',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Auto Scaling Group Lifecycle & Instance Replacement Strategy',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy managed Auto Scaling Group lifecycle behavior to maintain availability and deployment safety.

ASG Strategies Implemented:
- Blue/Green parallel ASGs during deployment
- Canary traffic shifting via target group weighting
- Controlled termination using ShouldDecrementDesiredCapacity
- Launch Template version pinning
- Automated instance replacement after template updates

Instance Hardening:
- Enforced IMDSv2 (HttpTokens required)
- Enabled instance metadata tags
- Activated detailed monitoring
- Ensured SSM-only management for private instances

Deployment Integration:
- Updated ASGs dynamically during CodePipeline execution
- Coordinated Launch Template version updates with AMI bake stage
- Ensured instance boot sequence validated nginx, php-fpm, and health endpoints before promotion

Failure Handling:
- Automatic rollback via CodeDeploy
- Manual rejection path before full traffic shift
- Controlled cleanup of obsolete ASGs

Outcome:
Improved high availability posture and minimized risk during rolling infrastructure updates.
EOT,
                'source' => 'experience-asg-lifecycle-management',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Redis, Queue Systems & Concurrency Control',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy engineered reliable Redis-backed queue systems for Laravel production workloads.

Redis Usage:
- Queue backend
- Concurrency locks
- Distributed job coordination

Concurrency Controls:
- 30-minute Redis locks to prevent duplicate schedule execution
- Idempotent job logic
- Explicit retry caps for patient retry flows
- Segmentation by program group and pharmacy group

SSL/TLS Debugging:
- Diagnosed stream_socket_enable_crypto SSL errors
- Investigated OpenSSL wrong version number issues
- Validated TLS compatibility between Laravel and AWS-managed Redis

Performance Stabilization:
- Reduced long-running job contention
- Prevented overlapping schedule execution
- Reduced database pressure during retry runs
- Improved throughput consistency

Operational Insight:
Background jobs do not directly cause frontend slowness, but database and queue load spikes can indirectly impact user experience.

Impact:
Higher reliability, safer concurrency handling, and predictable job execution timing.
EOT,
                'source' => 'experience-redis-queue-engineering',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Full-Stack Vue.js & Laravel Application Engineering',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy operates as a full-stack engineer specializing in Laravel and Vue.js with deep DevOps integration.

Backend:
- Laravel API architecture
- Eloquent ORM optimization
- Artisan command automation
- RESTful API design
- Secure authentication workflows

Frontend:
- Vue.js SPA development
- TailwindCSS UI modernization
- Modal-based component architecture
- Softphone CCP v2 integration
- Real-time UI state synchronization during active calls

Integration Patterns:
- CRM data hydration during active calls
- Secure token exchange between frontend and backend
- WebSocket upgrade handling
- WebRTC considerations behind Nginx proxy

DevOps Integration:
- Backend deploy automation
- AMI baking integration
- Environment-specific configuration management

Outcome:
Delivered production-grade full-stack systems tightly integrated with AWS infrastructure.
EOT,
                'source' => 'experience-fullstack-vue-laravel',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Development Environment Engineering & Productivity Systems',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy engineered optimized development environments to mirror production and reduce deployment friction.

Environment Stack:
- Ubuntu 24.04
- Zsh with Powerlevel10k
- Composer automation
- Node & React Native tooling
- Kotlin Android development with Jetpack Compose
- Local-to-cloud parity workflows

Philosophy:
- Reproducible environments
- Minimal configuration drift
- Fast feedback loops
- Clear separation between build and runtime dependencies

Tooling Practices:
- Standardized shell configuration
- Structured buildspec files
- Modular Terraform organization
- Consistent naming conventions across environments

Impact:
Reduced developer onboarding time, minimized configuration errors, and improved deployment predictability.
EOT,
                'source' => 'experience-dev-environment-engineering',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Architectural Strategy & Long-Term Platform Vision',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy consistently approaches systems with long-term scalability and maintainability in mind.

Architectural Decisions:
- Provider-agnostic communication layer (Amazon Connect, Twilio, 8x8)
- Modular Terraform modules
- Immutable infrastructure strategy
- Event-driven Lambda automation
- Segmented queue workloads
- Blue/Green deployment planning

Identified Future Improvements:
- Full Blue/Green completion with stronger isolation
- Dedicated queue EC2 instance to separate workload from production server
- Expanded observability instrumentation
- Further workload isolation for stability

Strategic Themes:
- Reduce vendor lock-in
- Minimize blast radius of failures
- Automate repetitive infrastructure tasks
- Improve deployment confidence
- Prioritize reliability over convenience

Outcome:
Shifted the platform from reactive maintenance toward intentional, scalable systems design.
EOT,
                'source' => 'experience-architectural-strategy-vision',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – CodePipeline 7-Stage Deployment Architecture (Deep Technical Breakdown)',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy engineered a fully automated 7-stage AWS CodePipeline designed for production-safe deployments using immutable infrastructure principles.

Pipeline Architecture Overview:
1. Source Stage
   - Git-based trigger
   - Version-controlled infrastructure and application code

2. Build Stage
   - CodeBuild compiles application artifacts
   - Runs validation and packaging

3. AMI Bake Stage (Packer)
   - buildspec-packer.yml
   - Creates new AMI with application pre-installed
   - Updates Launch Template version
   - Updates Auto Scaling Group to use new template

4. Canary Deployment Stage
   - CodeDeploy shifts 10% traffic to new environment
   - Validates infrastructure health before full rollout

5. Manual Approval Stage
   - Human review gate
   - Prevents automatic 100% shift without validation

6. Promote Stage
   - Uses codedeploy continue-deployment
   - Completes traffic shift to 100%

7. Cleanup Stage
   - buildspec-cleanup.yml
   - Terminates previous blue ASG
   - Deletes obsolete Target Group
   - Rotates SSM parameters tracking current production resources

Supporting Files:
- appspec.yml
- scripts/validate-service.sh
- Terraform modules for IAM, CodeDeploy, and Pipeline
- Structured outputs.tf for resource introspection

Key Design Decisions:
- Two CodeDeploy actions instead of one due to pause limitations
- Immutable AMI strategy instead of in-place deployments
- SSM parameters used for dynamic state tracking
- Explicit health checks before traffic promotion

Outcome:
Highly reliable, production-safe deployment workflow with rollback safety and infrastructure traceability.
EOT,
                'source' => 'experience-codepipeline-7-stage-architecture',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Registration Retry System Engineering & Business Logic Alignment',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy led deep analysis and restructuring of the Registration Retry system to align technical implementation with business expectations.

Original Business Context:
Retry failed patient registrations based on configurable schedules, pharmacy groups, and program groupings.

Core Job Logic:
- RegistrationRetryScheduleJob validates schedule configuration
- Ensures program_ids are valid
- Validates pharmacy exclusion filters
- Applies retry caps per patient group
- Enforces daily processing limits (100–250 patients)
- Executes lift:registration-retry-eloquent Artisan command

Concurrency Protection:
- Redis lock (30-minute timeout)
- Prevents duplicate execution of same schedule
- Avoids race conditions under heavy queue load

Segmentation Strategy:
- Split schedules by program groups (e.g., weight-loss vs migraine)
- Split by pharmacy groups (Publix, HEB, others)
- Prevented massive single-batch processing

Monitoring Enhancements:
- Execution time logging
- Warning if runtime exceeds threshold
- Structured failure logging

Gap Analysis Sessions:
- Identified inconsistencies between business expectations and system behavior
- Documented edge cases and failure conditions
- Clarified retry counts and segmentation rules

Impact:
Massively improved performance, reduced system strain, and clarified business alignment.
EOT,
                'source' => 'experience-registration-retry-engineering',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Advanced AWS Security & Access Control Governance',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy enforced secure-by-default AWS configurations across infrastructure.

IAM Governance:
- Created distinct roles for Pipeline, CodeBuild, CodeDeploy, and Packer
- Implemented least-privilege permissions
- Managed CAPABILITY_NAMED_IAM deployments carefully

Network Security:
- Restricted inbound CIDR ranges
- Verified MongoDB port 27017 CIDR corrections
- Ensured private instances had no public IPs
- Used NAT gateways for controlled egress

Instance Hardening:
- Enforced IMDSv2 required tokens
- Enabled metadata tags
- Enabled detailed monitoring
- Restricted SSH exposure (SSM-based management)

Application Security:
- Strict CORS headers
- Brute-force mitigation
- CSP and SRI implementation
- Suppressed server signature headers

Operational Security:
- Verified actual AWS state through CLI inspection
- Audited route tables and security group rules regularly
- Confirmed SSM endpoint deployment in every subnet

Outcome:
Reduced attack surface and increased infrastructure integrity.
EOT,
                'source' => 'experience-aws-security-governance',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Health Checks, Observability & Service Validation',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy implemented multi-layer service validation to ensure deployments were safe before promotion.

Validation Layers:
- nginx process check
- php-fpm process check
- Application /health endpoint validation
- Reverb (real-time communication) health checks

ValidateService Hook:
- Defined in appspec.yml
- Executes during CodeDeploy lifecycle
- Fails deployment if service validation fails

Monitoring:
- Logged execution times for long-running jobs
- Structured queue failure logging
- CloudWatch log inspection during incidents
- Added runtime warnings for excessive execution time

Health Philosophy:
Deployment must prove it works before receiving full traffic.

Impact:
Reduced failed releases, prevented broken deployments from going live, and improved operational confidence.
EOT,
                'source' => 'experience-health-checks-observability',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Cost Optimization & Infrastructure Efficiency Strategy',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy implemented measurable cost savings and efficiency improvements across AWS environments.

Cost Reduction Strategies:
- Eliminated redundant infrastructure
- Cleaned orphaned route tables and NAT resources
- Migrated to zonal NAT gateways for optimized routing
- Reduced excessive compute usage from long-running jobs
- Optimized queue worker configurations

Deployment Efficiency:
- Immutable AMI strategy reduced drift and rework
- Automated cleanup prevented unused ASGs from persisting
- Reduced manual operational overhead with Lambda automation

Performance Efficiency:
- Reduced retry job runtime dramatically
- Controlled batch sizes to avoid compute spikes
- Balanced ASG scaling to match workload

Financial Impact:
~$30,000/year infrastructure savings.

Operational Impact:
Reduced waste, improved reliability, and improved deployment confidence.
EOT,
                'source' => 'experience-cost-optimization-strategy',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Leadership, Ownership & Technical Decision-Making',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy demonstrated strong technical ownership and decision-making authority across engineering and infrastructure domains.

Leadership Characteristics:
- Took sole responsibility for AWS production infrastructure
- Proactively identified architectural weaknesses
- Proposed Blue/Green and workload separation strategies
- Led modernization efforts without requiring external direction

Decision-Making Approach:
- Prefer automation over manual intervention
- Prioritize reliability over short-term convenience
- Design for failure tolerance
- Separate workloads to reduce blast radius
- Build modular, vendor-agnostic systems

Cross-Functional Collaboration:
- Clarified business expectations during retry gap analysis
- Aligned system behavior with operational requirements
- Improved documentation for disaster recovery testing

Strategic Outcome:
Transitioned the platform from reactive maintenance to intentional architecture-driven engineering.
EOT,
                'source' => 'experience-leadership-technical-ownership',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Vue.js Softphone Architecture with Amazon Connect Streams API',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy architected and implemented a browser-based softphone using Vue.js integrated with Amazon Connect via the Amazon Connect Streams API.

Core Objective:
Replace or extend the default Contact Control Panel (CCP) with a custom Vue.js interface tailored to business workflows.

Technology Stack:
- Vue.js 3 (Composition API)
- JavaScript / TypeScript
- Amazon Connect Streams API
- WebRTC for audio handling
- Laravel backend for authentication and token management

Key Capabilities Implemented:
- Agent login and state management (Available, Offline, After Call Work)
- Contact event listeners (onIncoming, onAccepted, onEnded)
- Real-time UI updates reflecting call lifecycle
- Call controls: accept, reject, hold, resume, transfer
- Softphone mute/unmute controls
- Contact attributes retrieval and display
- Integration with CRM data via Laravel API

Security Considerations:
- Secure iframe embedding of CCP when required
- Controlled origin policies
- Proper initialization of connect.core.initCCP
- Handling session expiration and reconnection logic

Advanced Customization:
- Dynamic agent routing insights
- Displaying contact attributes for contextual workflows
- Automated disposition tracking
- Integration with internal systems for ticketing and logging

Outcome:
Delivered a highly customized, business-aligned softphone that improved agent workflow efficiency and allowed deep UI customization beyond the default Amazon Connect CCP.
EOT,
                'source' => 'experience-vue-softphone-amazon-connect',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Skills – Amazon Connect Development & Streams API Expertise',
                'type' => 'skills',
                'content' => <<<EOT
Jeremy has deep hands-on expertise with Amazon Connect architecture and development.

Core Areas of Expertise:
- Amazon Connect Streams API integration
- Custom Contact Control Panel (CCP) development
- Agent event lifecycle handling
- Real-time contact state synchronization
- WebRTC softphone configuration
- Call routing and queue design
- Contact flows and Lambda integrations
- Agent workspace customization

Advanced Integrations:
- Laravel backend coordination with Amazon Connect
- SSM parameter usage for environment config
- Lambda automation for Connect workflows
- Custom UI dashboards for supervisors

DevOps Integration:
- CI/CD deployment for Connect-integrated apps
- Environment separation (dev/stage/prod)
- Secure IAM configuration for Connect resources

Use Cases:
- Custom Vue softphone
- CRM-integrated call experience
- Automated call disposition workflows
- Advanced reporting dashboards

Jeremy positions Amazon Connect not just as a call center, but as an extensible cloud communications platform.
EOT,
                'source' => 'skills-amazon-connect-development',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – CI/CD Debugging & Terraform AWS Provider v5 Migration',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy diagnosed and resolved infrastructure deployment failures during Terraform AWS provider v5 migration.

Problem Encountered:
Unsupported arguments (e.g., canary_percentage) in aws_codedeploy_deployment_config due to provider changes.

Actions Taken:
- Reviewed AWS provider v5 documentation
- Identified deprecated attributes
- Refactored CodeDeploy deployment configuration
- Ensured compatibility with updated provider schema
- Validated through terraform plan and apply cycles

Pipeline Stability Improvements:
- Added validation steps before deployment
- Introduced structured module outputs
- Reduced drift between Terraform state and AWS reality
- Confirmed stack state before updates (avoiding ROLLBACK_COMPLETE errors)

CloudFormation Debugging:
- Diagnosed stack stuck in ROLLBACK_COMPLETE
- Determined when stack replacement was required
- Ensured clean state before redeployment

Outcome:
Stabilized CI/CD infrastructure during major provider upgrade and prevented production pipeline failures.
EOT,
                'source' => 'experience-terraform-v5-migration',
                'chunk_index' => 0,
            ],

            [
                'title' => 'FAQ – How Does Jeremy Approach DevOps and CI/CD Architecture?',
                'type' => 'faq',
                'content' => <<<EOT
Question:
How does Jeremy design CI/CD pipelines for production systems?

Answer:
Jeremy follows an immutable infrastructure and automation-first philosophy.

Key Principles:
- Infrastructure as Code (Terraform)
- Immutable AMI deployments (Packer)
- Blue/Green traffic shifting (CodeDeploy)
- Manual approval gates before full rollout
- Automated cleanup to prevent resource drift
- Health validation before traffic promotion

Operational Beliefs:
- Deployments must be reversible
- Manual processes are failure points
- Pipelines should fail fast and visibly
- Production state must always be inspectable via CLI

He designs pipelines not just to deploy code, but to protect the business from deployment risk.
EOT,
                'source' => 'faq-devops-ci-cd-approach',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Nginx Performance & Security Hardening',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy configured and optimized Nginx for performance, security, and real-time workloads.

Performance Enhancements:
- IP-based rate limiting (limit_req)
- Burst control with nodelay
- Efficient try_files routing
- Optimized worker processes and connections

WebSocket & Real-Time Support:
- Upgrade header mapping
- Proxy configuration for WebSocket upgrades
- Stable Reverb and real-time broadcast handling

Security Controls:
- Strict CORS configuration
- CSP headers
- Server token suppression
- Redirect HTTP to HTTPS enforcement
- Controlled server_name matching for wildcard domains

Scalability:
- Configured Nginx to handle multiple subdomains dynamically
- Ensured compatibility with Auto Scaling Groups

Outcome:
High-performance, secure edge layer capable of supporting production traffic and real-time communication systems.
EOT,
                'source' => 'experience-nginx-performance-hardening',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – SSM-Only Private Infrastructure & VPC Endpoint Architecture',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy designed private AWS environments without public SSH access, using SSM-based management.

Architecture:
- Private EC2 instances (no public IPs)
- NAT gateway for outbound internet access
- SSM VPC endpoints (ssm, ec2messages, ssmmessages)
- Proper route table configuration
- Instance profile roles for SSM access

Problem Solved:
SSM Agent unable to acquire credentials due to endpoint misconfiguration.

Resolution Steps:
- Verified VPC endpoints were deployed in correct subnets
- Ensured security groups allowed port 443 outbound
- Confirmed IAM role attached to instance
- Validated route tables and DNS resolution

Security Philosophy:
Eliminate SSH exposure entirely.
Manage instances via AWS Systems Manager.

Outcome:
Fully private, auditable infrastructure with secure management workflows.
EOT,
                'source' => 'experience-ssm-private-infrastructure',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Philosophy – Automation, Observability, and Intentional Architecture',
                'type' => 'philosophy',
                'content' => <<<EOT
Jeremy believes strong systems are built intentionally, not reactively.

Core Beliefs:
- Automate everything repeatable
- Observe everything critical
- Separate workloads to reduce blast radius
- Validate deployments before trust
- Reduce human dependency in production systems

Engineering Philosophy:
- Design for failure tolerance
- Prefer immutable infrastructure
- Avoid hidden state
- Build with auditability in mind
- Ensure business logic matches system behavior

Professional Identity:
Senior Full-Stack Developer and Cloud Architect focused on Laravel, Vue.js, AWS, DevOps, and Amazon Connect.

Jeremy builds systems that scale, self-heal, and protect the business from operational risk.
EOT,
                'source' => 'philosophy-automation-observability-architecture',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Vue.js Softphone Architecture with Amazon Connect Streams API',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy architected and implemented a browser-based softphone using Vue.js integrated with Amazon Connect via the Amazon Connect Streams API.

Core Objective:
Replace or extend the default Contact Control Panel (CCP) with a custom Vue.js interface tailored to business workflows.

Technology Stack:
- Vue.js 3 (Composition API)
- JavaScript / TypeScript
- Amazon Connect Streams API
- WebRTC for audio handling
- Laravel backend for authentication and token management

Key Capabilities Implemented:
- Agent login and state management (Available, Offline, After Call Work)
- Contact event listeners (onIncoming, onAccepted, onEnded)
- Real-time UI updates reflecting call lifecycle
- Call controls: accept, reject, hold, resume, transfer
- Softphone mute/unmute controls
- Contact attributes retrieval and display
- Integration with CRM data via Laravel API

Security Considerations:
- Secure iframe embedding of CCP when required
- Controlled origin policies
- Proper initialization of connect.core.initCCP
- Handling session expiration and reconnection logic

Advanced Customization:
- Dynamic agent routing insights
- Displaying contact attributes for contextual workflows
- Automated disposition tracking
- Integration with internal systems for ticketing and logging

Outcome:
Delivered a highly customized, business-aligned softphone that improved agent workflow efficiency and allowed deep UI customization beyond the default Amazon Connect CCP.
EOT,
                'source' => 'experience-vue-softphone-amazon-connect',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Skills – Amazon Connect Development & Streams API Expertise',
                'type' => 'skills',
                'content' => <<<EOT
Jeremy has deep hands-on expertise with Amazon Connect architecture and development.

Core Areas of Expertise:
- Amazon Connect Streams API integration
- Custom Contact Control Panel (CCP) development
- Agent event lifecycle handling
- Real-time contact state synchronization
- WebRTC softphone configuration
- Call routing and queue design
- Contact flows and Lambda integrations
- Agent workspace customization

Advanced Integrations:
- Laravel backend coordination with Amazon Connect
- SSM parameter usage for environment config
- Lambda automation for Connect workflows
- Custom UI dashboards for supervisors

DevOps Integration:
- CI/CD deployment for Connect-integrated apps
- Environment separation (dev/stage/prod)
- Secure IAM configuration for Connect resources

Use Cases:
- Custom Vue softphone
- CRM-integrated call experience
- Automated call disposition workflows
- Advanced reporting dashboards

Jeremy positions Amazon Connect not just as a call center, but as an extensible cloud communications platform.
EOT,
                'source' => 'skills-amazon-connect-development',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – CI/CD Debugging & Terraform AWS Provider v5 Migration',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy diagnosed and resolved infrastructure deployment failures during Terraform AWS provider v5 migration.

Problem Encountered:
Unsupported arguments (e.g., canary_percentage) in aws_codedeploy_deployment_config due to provider changes.

Actions Taken:
- Reviewed AWS provider v5 documentation
- Identified deprecated attributes
- Refactored CodeDeploy deployment configuration
- Ensured compatibility with updated provider schema
- Validated through terraform plan and apply cycles

Pipeline Stability Improvements:
- Added validation steps before deployment
- Introduced structured module outputs
- Reduced drift between Terraform state and AWS reality
- Confirmed stack state before updates (avoiding ROLLBACK_COMPLETE errors)

CloudFormation Debugging:
- Diagnosed stack stuck in ROLLBACK_COMPLETE
- Determined when stack replacement was required
- Ensured clean state before redeployment

Outcome:
Stabilized CI/CD infrastructure during major provider upgrade and prevented production pipeline failures.
EOT,
                'source' => 'experience-terraform-v5-migration',
                'chunk_index' => 0,
            ],

            [
                'title' => 'FAQ – How Does Jeremy Approach DevOps and CI/CD Architecture?',
                'type' => 'faq',
                'content' => <<<EOT
Question:
How does Jeremy design CI/CD pipelines for production systems?

Answer:
Jeremy follows an immutable infrastructure and automation-first philosophy.

Key Principles:
- Infrastructure as Code (Terraform)
- Immutable AMI deployments (Packer)
- Blue/Green traffic shifting (CodeDeploy)
- Manual approval gates before full rollout
- Automated cleanup to prevent resource drift
- Health validation before traffic promotion

Operational Beliefs:
- Deployments must be reversible
- Manual processes are failure points
- Pipelines should fail fast and visibly
- Production state must always be inspectable via CLI

He designs pipelines not just to deploy code, but to protect the business from deployment risk.
EOT,
                'source' => 'faq-devops-ci-cd-approach',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Nginx Performance & Security Hardening',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy configured and optimized Nginx for performance, security, and real-time workloads.

Performance Enhancements:
- IP-based rate limiting (limit_req)
- Burst control with nodelay
- Efficient try_files routing
- Optimized worker processes and connections

WebSocket & Real-Time Support:
- Upgrade header mapping
- Proxy configuration for WebSocket upgrades
- Stable Reverb and real-time broadcast handling

Security Controls:
- Strict CORS configuration
- CSP headers
- Server token suppression
- Redirect HTTP to HTTPS enforcement
- Controlled server_name matching for wildcard domains

Scalability:
- Configured Nginx to handle multiple subdomains dynamically
- Ensured compatibility with Auto Scaling Groups

Outcome:
High-performance, secure edge layer capable of supporting production traffic and real-time communication systems.
EOT,
                'source' => 'experience-nginx-performance-hardening',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – SSM-Only Private Infrastructure & VPC Endpoint Architecture',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy designed private AWS environments without public SSH access, using SSM-based management.

Architecture:
- Private EC2 instances (no public IPs)
- NAT gateway for outbound internet access
- SSM VPC endpoints (ssm, ec2messages, ssmmessages)
- Proper route table configuration
- Instance profile roles for SSM access

Problem Solved:
SSM Agent unable to acquire credentials due to endpoint misconfiguration.

Resolution Steps:
- Verified VPC endpoints were deployed in correct subnets
- Ensured security groups allowed port 443 outbound
- Confirmed IAM role attached to instance
- Validated route tables and DNS resolution

Security Philosophy:
Eliminate SSH exposure entirely.
Manage instances via AWS Systems Manager.

Outcome:
Fully private, auditable infrastructure with secure management workflows.
EOT,
                'source' => 'experience-ssm-private-infrastructure',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Philosophy – Automation, Observability, and Intentional Architecture',
                'type' => 'philosophy',
                'content' => <<<EOT
Jeremy believes strong systems are built intentionally, not reactively.

Core Beliefs:
- Automate everything repeatable
- Observe everything critical
- Separate workloads to reduce blast radius
- Validate deployments before trust
- Reduce human dependency in production systems

Engineering Philosophy:
- Design for failure tolerance
- Prefer immutable infrastructure
- Avoid hidden state
- Build with auditability in mind
- Ensure business logic matches system behavior

Professional Identity:
Senior Full-Stack Developer and Cloud Architect focused on Laravel, Vue.js, AWS, DevOps, and Amazon Connect.

Jeremy builds systems that scale, self-heal, and protect the business from operational risk.
EOT,
                'source' => 'philosophy-automation-observability-architecture',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Project – LoanShield Cross-Platform Loan Risk Analysis Application',
                'type' => 'project',
                'content' => <<<EOT
Jeremy is the founder and architect of LoanShield, a cross-platform mobile and web application designed to help consumers analyze loan contracts and avoid going underwater on auto, housing, and personal loans.

Architecture:
- Flutter (iOS, Android, Web)
- Laravel API backend
- JWT-based authentication
- AWS-hosted infrastructure
- RESTful API design
- VIN scanning via barcode and OCR

Core Features:
- Loan-to-value (LTV) calculations
- Amortization schedule projections
- Underwater risk detection
- Maintenance cost estimations
- Consumer protection insights
- Dealer rating aggregation
- Scam detection indicators

Backend Capabilities:
- Secure API authentication
- Loan calculation engine
- Risk scoring logic
- User profile and loan storage
- Event-driven notifications

Consumer Protection Focus:
- Transparent breakdown of interest
- Early payoff impact analysis
- Warning indicators for high-risk loans
- Clear visualization of long-term financial exposure

Outcome:
LoanShield positions Jeremy not only as a developer, but as a product-oriented engineer capable of building scalable SaaS platforms with real-world consumer impact.
EOT,
                'source' => 'project-loanshield-platform',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Skills – Laravel Backend Architecture & API Design',
                'type' => 'skills',
                'content' => <<<EOT
Jeremy specializes in advanced Laravel backend development and API architecture.

Core Backend Competencies:
- RESTful API design
- JWT and session-based authentication
- Eloquent ORM optimization
- Queue system architecture
- Horizon monitoring
- Redis caching strategies
- Multi-environment configuration management

Advanced Laravel Capabilities:
- Custom Artisan command development
- Background job segmentation
- Retry logic engineering
- Event-driven workflows
- Middleware security layers
- Rate limiting and brute-force mitigation

Production-Level Concerns:
- CI/CD integration
- Health endpoints
- Service validation hooks
- Structured logging
- Error tracking integration
- High-availability architecture

Jeremy builds Laravel systems designed for scale, observability, and long-term maintainability.
EOT,
                'source' => 'skills-laravel-backend-architecture',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Real-Time Systems with WebSockets and Laravel Reverb',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy implemented real-time communication systems using WebSockets and Laravel Reverb.

Core Capabilities:
- Broadcasting events from Laravel
- WebSocket server configuration
- Nginx WebSocket proxy upgrade handling
- Connection lifecycle management
- Authentication for private channels

Use Cases:
- Real-time softphone state updates
- Live queue dashboards
- Agent presence tracking
- Event-driven UI updates in Vue applications

Operational Considerations:
- Health checks for WebSocket services
- Ensuring compatibility with Auto Scaling Groups
- Proper sticky session management when required
- Load balancer configuration for WebSocket persistence

Outcome:
Stable real-time communication architecture capable of supporting production workloads and dynamic agent interfaces.
EOT,
                'source' => 'experience-realtime-websockets-laravel',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Debugging Production Slowness & Database Spike Analysis',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy performed root cause analysis for reported system slowness in production environments.

Investigation Areas:
- Background job impact analysis
- Database request spike correlation
- Queue worker behavior inspection
- Monitoring graph interpretation
- Separation of synchronous vs asynchronous workloads

Key Finding:
Background jobs (e.g., retry processes) were not directly affecting user-facing performance.

Actions Taken:
- Verified database performance metrics
- Reviewed queue execution timing
- Confirmed absence of blocking synchronous processes
- Communicated technical clarification to stakeholders

Engineering Principle:
Do not assume correlation equals causation.
Validate system behavior with data.

Outcome:
Improved clarity between operational perception and technical reality.
EOT,
                'source' => 'experience-production-slowness-analysis',
                'chunk_index' => 0,
            ],

            [
                'title' => 'FAQ – How Does Jeremy Handle High-Risk Production Changes?',
                'type' => 'faq',
                'content' => <<<EOT
Question:
How does Jeremy approach risky infrastructure or production changes?

Answer:
Jeremy minimizes risk through structure, validation, and rollback capability.

Methods:
- Immutable AMI deployments
- Blue/Green traffic shifting
- Canary release strategy
- Manual approval gates
- Automated cleanup of old infrastructure
- Health validation scripts before promotion

Risk Mitigation Philosophy:
- Every deployment must be reversible
- Avoid in-place mutation of production servers
- Separate critical workloads
- Log everything important

Jeremy treats production as a protected environment that must be engineered carefully, not experimented on.
EOT,
                'source' => 'faq-production-risk-management',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Infrastructure Introspection via AWS CLI & Automation',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy frequently uses AWS CLI for deep infrastructure inspection and verification.

Common Commands Used:
- aws autoscaling describe-auto-scaling-groups
- aws ec2 describe-route-tables
- aws ec2 describe-security-groups
- aws cloudformation describe-stacks
- aws codepipeline get-pipeline
- aws deploy get-deployment

Use Cases:
- Verifying actual deployed configuration
- Inspecting ASG desired capacity
- Confirming termination behavior (ShouldDecrementDesiredCapacity)
- Diagnosing ROLLBACK_COMPLETE stack states
- Validating VPC endpoint presence

Philosophy:
Always verify real AWS state rather than assuming Terraform state accuracy.

Outcome:
Reduced configuration drift and improved confidence in production infrastructure.
EOT,
                'source' => 'experience-aws-cli-infrastructure-introspection',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Ubuntu 24.04 Developer Environment Optimization',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy configured an optimized Ubuntu 24.04 development workstation for Laravel, React Native, and DevOps workflows.

Shell & Productivity Enhancements:
- zsh with powerlevel10k
- Useful zsh plugins for git and autosuggestions
- Custom aliases for AWS CLI and Terraform
- Structured .env management

Development Tooling:
- Node.js and npm setup
- PHP and Composer configuration
- React Native Android toolchain
- MongoDB shell installation
- Docker integration
- Terraform CLI installation

Workflow Optimization:
- Fast Git operations
- Integrated AWS profile management
- Streamlined CI/CD testing locally
- Organized project directory structure

Outcome:
High-efficiency local development environment aligned with production cloud workflows.
EOT,
                'source' => 'experience-ubuntu-dev-environment-optimization',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Blue/Green Deployment Strategy with AWS CodeDeploy',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy implemented a production-grade Blue/Green deployment strategy using AWS CodeDeploy integrated with Auto Scaling Groups and Application Load Balancers.

Architecture Components:
- Two Auto Scaling Groups (Blue and Green)
- Two Target Groups
- Application Load Balancer listener rules
- CodeDeploy Deployment Group
- Traffic shifting configuration (canary and full rollout)

Deployment Flow:
1. New AMI baked via Packer
2. Green ASG created with updated Launch Template
3. CodeDeploy shifts 10% traffic to Green
4. Health validation executed
5. Manual approval step
6. Traffic shifted to 100%
7. Blue environment terminated during cleanup

Rollback Safety:
- Automatic rollback if health checks fail
- Previous ASG preserved until promotion completes
- No in-place instance mutation

Benefits:
- Zero-downtime deployments
- Fast rollback capability
- Reduced configuration drift
- Clear separation between old and new environments

Outcome:
Production deployments became predictable, safe, and auditable.
EOT,
                'source' => 'experience-blue-green-codedeploy',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Skills – Terraform Infrastructure as Code (AWS-Focused)',
                'type' => 'skills',
                'content' => <<<EOT
Jeremy has advanced experience writing and maintaining Terraform modules for AWS infrastructure.

Core Resources Managed:
- VPCs, subnets, route tables
- NAT gateways and Internet gateways
- Security groups and NACLs
- EC2 Launch Templates
- Auto Scaling Groups
- CodePipeline, CodeBuild, CodeDeploy
- IAM roles and policies
- SSM parameters
- VPC endpoints

Best Practices:
- Modularized infrastructure design
- Reusable Terraform modules
- outputs.tf for cross-module referencing
- Remote state management
- Explicit variable validation
- Controlled provider version upgrades

Migration Expertise:
- AWS provider v5 compatibility refactoring
- Deprecated argument removal
- Safe state transitions

Jeremy treats Terraform as the single source of truth for infrastructure.
EOT,
                'source' => 'skills-terraform-aws-iac',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Rate Limiting & Brute Force Protection Architecture',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy implemented layered brute-force protection for authentication systems.

Layer 1 – Nginx Rate Limiting:
- limit_req zone configuration
- Burst control with nodelay
- IP-based throttling on /login endpoint

Layer 2 – Application-Level Protection:
- Laravel throttle middleware
- Request frequency limits per IP and user
- Temporary lockouts

Layer 3 – Administrative Controls:
- Manual admin lock/unlock capability in User Manager
- Audit logging for lock events
- Clear error messaging for locked users

Security Outcome:
- Mitigated credential stuffing
- Reduced attack surface
- Protected authentication endpoints under load

Engineering Principle:
Security should exist at multiple layers, not just inside application code.
EOT,
                'source' => 'experience-brute-force-protection',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – AWS Auto Scaling Group Management & Instance Lifecycle Control',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy actively manages Auto Scaling Groups (ASGs) for production workloads.

Core Responsibilities:
- Launch Template versioning
- Desired capacity tuning
- Instance refresh strategies
- Controlled instance termination
- Understanding ShouldDecrementDesiredCapacity behavior

Operational Insights:
- Terminating instances without decrementing capacity when needed
- Preventing unintended scale-down events
- Validating instance health before removal
- Coordinating ASG changes during deployments

Monitoring:
- Observing scaling events in CloudWatch
- Validating target group registration
- Ensuring health check alignment between ALB and ASG

Outcome:
Stable, predictable scaling behavior aligned with deployment workflows.
EOT,
                'source' => 'experience-asg-lifecycle-management',
                'chunk_index' => 0,
            ],

            [
                'title' => 'FAQ – What Makes Jeremy Different from a Typical Full-Stack Developer?',
                'type' => 'faq',
                'content' => <<<EOT
Question:
What differentiates Jeremy from other Laravel or Vue developers?

Answer:
Jeremy operates at the intersection of application engineering and cloud infrastructure architecture.

Differentiators:
- Designs CI/CD pipelines, not just application features
- Implements immutable infrastructure strategies
- Builds custom Amazon Connect softphones
- Engineers real-time systems
- Analyzes production performance issues using infrastructure-level data
- Applies security best practices across multiple layers

He understands:
- Backend logic
- Frontend UX
- Cloud networking
- DevOps automation
- Deployment risk management

Jeremy delivers complete systems, not isolated code.
EOT,
                'source' => 'faq-differentiation-fullstack-cloud',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Experience – Queue Architecture & Background Job Optimization',
                'type' => 'experience',
                'content' => <<<EOT
Jeremy designed and optimized Laravel queue systems for reliability and scalability.

Key Components:
- Redis-backed queues
- Horizon monitoring
- Job segmentation by category
- Retry logic management
- Execution time measurement

Optimization Strategies:
- Split large batch jobs into smaller segments
- Avoid long-running blocking processes
- Limit per-run record counts
- Prevent duplicate execution via distributed locks
- Log slow job execution warnings

Operational Benefits:
- Reduced compute spikes
- Improved database stability
- Increased observability into background processes
- Clear distinction between async and user-facing workloads

Outcome:
Reliable queue architecture capable of handling large-scale background processing safely.
EOT,
                'source' => 'experience-queue-architecture-optimization',
                'chunk_index' => 0,
            ],

            [
                'title' => 'Philosophy – Production Systems Should Be Boring',
                'type' => 'philosophy',
                'content' => <<<EOT
Jeremy believes production systems should be predictable and boring.

Core Concept:
Excitement belongs in development, not in production.

Principles:
- Eliminate surprises through automation
- Remove manual intervention wherever possible
- Keep infrastructure deterministic
- Design for rollback
- Monitor critical systems continuously

Operational Mantra:
If a deployment feels risky, the pipeline design is incomplete.

Jeremy builds systems that make releases routine and uneventful.
EOT,
                'source' => 'philosophy-production-systems-boring',
                'chunk_index' => 0,
            ],

        ];
    }
}
