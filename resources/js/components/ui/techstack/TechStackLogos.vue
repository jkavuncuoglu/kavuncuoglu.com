<script setup lang="ts">
import { ref, computed } from 'vue';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import TechLogo from '@/components/ui/techstack/TechLogo.vue';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from '@/components/ui/dialog';

interface TechItem {
    name: string;
    sub: string;
    img?: string;
    kind?: string;
    compliance?: boolean;
    detail: string;
    highlights: string[];
}

defineProps<{ monochrome?: boolean }>();

const selectedTech = ref<TechItem | null>(null);
const dialogOpen = ref(false);

const openTech = (item: TechItem) => {
    selectedTech.value = item;
    dialogOpen.value = true;
};

const ITEMS_PER_PAGE = 15;
const currentPage = ref(0);

const stack: TechItem[] = [
    // ── Frontend ──────────────────────────────────────────────────
    {
        name: 'Laravel',
        sub: 'v12',
        img: '/images/brands/laravel.jpeg',
        detail: 'Primary PHP framework used across all major projects. Leveraged Eloquent ORM, job queues, broadcasting, and Artisan CLI. Led a zero-downtime migration from Laravel 6 to v12 at Pleio.',
        highlights: ['Upgraded v6 → v12 in production', 'Eloquent ORM & query optimisation', 'Job queues, events & broadcasting', 'Custom Artisan commands & seeders', 'API resources & form validation'],
    },
    {
        name: 'Vue.js',
        sub: 'v3 · Inertia.js',
        img: '/images/brands/vue-js.png',
        detail: 'Primary frontend framework. Builds component-driven SPAs using the Composition API and TypeScript. Migrated large production codebases from Vue 2 to Vue 3.',
        highlights: ['Migrated Vue 2 → Vue 3 in production', 'Composition API & <script setup>', 'Inertia.js SPA without a separate API', 'Custom composables & reactive patterns', 'shadcn/vue component library'],
    },
    {
        name: 'PHP',
        sub: '8.x',
        kind: 'php',
        detail: 'Server-side language used across enterprise healthcare and e-commerce platforms. Focus on clean OOP, SOLID principles, and leveraging PHP 8.x features for type-safe code.',
        highlights: ['PHP 8.x: enums, named args, fibers', 'SOLID principles & design patterns', 'PSR standards & strict typing', 'Composer ecosystem management', 'Dependency injection & service containers'],
    },
    {
        name: 'TypeScript',
        sub: 'Type Safety',
        kind: 'typescript',
        detail: 'Applied across all modern Vue.js frontends and Node.js services. Enforces type safety, improves IDE support, and catches bugs at compile time rather than runtime.',
        highlights: ['Full type coverage on Vue + Inertia apps', 'Custom type definitions & generics', 'Strict mode configuration', 'Interface-driven component props', 'Typed API response contracts'],
    },
    {
        name: 'Tailwind CSS',
        sub: 'Utility-First CSS',
        kind: 'tailwind',
        detail: 'Utility-first CSS framework for all recent projects. Enables rapid, consistent UI development with custom design tokens, dark mode, and responsive layouts.',
        highlights: ['Custom design system via CSS variables', 'Dark mode & responsive design', 'shadcn/vue component integration', 'Consistent spacing & typography scales', 'Animation & transition utilities'],
    },
    {
        name: 'Inertia.js',
        sub: 'SPA Routing',
        kind: 'inertia',
        detail: 'The bridge between Laravel backends and Vue 3 frontends — no separate API needed. Handles SPA routing, shared data, form submissions, and authentication flows seamlessly.',
        highlights: ['Server-side routing with SPA feel', 'Shared data via HandleInertiaRequests', 'Form handling & flash messages', 'Ziggy route helpers integration', 'SSR-ready architecture'],
    },
    {
        name: 'React',
        sub: 'UI Library',
        kind: 'react',
        detail: 'Used for Amazon Connect CCP (Contact Control Panel) custom UI components. Experienced with hooks, context, and building embeddable widgets integrated into broader Laravel apps.',
        highlights: ['Amazon Connect CCP integration', 'Custom hook patterns', 'Functional components with hooks', 'Context API for state sharing', 'Embeddable widget architecture'],
    },
    {
        name: 'Node.js',
        sub: 'JS Runtime',
        kind: 'nodejs',
        detail: 'Used for AWS Lambda functions, build tooling (Vite), and real-time processing pipelines. Experience with serverless functions and event-driven backend architectures.',
        highlights: ['AWS Lambda serverless functions', 'Vite build tooling & HMR', 'Event-driven processing pipelines', 'npm/bun package ecosystem', 'Streaming response handling'],
    },
    {
        name: 'WordPress',
        sub: 'CMS',
        kind: 'wordpress',
        detail: 'Built custom plugins and CLI tools for multi-site SEO automation at 360 Quote. Deep knowledge of the WP hook system, REST API, and bulk content management workflows.',
        highlights: ['Custom plugins for bulk SEO operations', 'WP-CLI tooling for automation', 'Multi-site management', 'REST API & custom endpoints', 'Metadata & URL structure optimisation'],
    },
    {
        name: 'REST APIs',
        sub: 'Web Services',
        kind: 'rest',
        detail: 'Designs and consumes RESTful APIs using HTTP standards. Focus on clear resource modelling, consistent error responses, versioning, and authentication security.',
        highlights: ['Laravel API Resources & transformers', 'JWT & Sanctum authentication', 'API versioning strategies', 'Rate limiting & throttling', 'OpenAPI / Swagger documentation'],
    },
    // ── Cloud & DevOps ────────────────────────────────────────────
    {
        name: 'AWS',
        sub: 'Lambda · ECS · S3',
        img: '/images/brands/amazon-web-services.png',
        detail: 'Managed the full AWS cloud environment at Pleio — optimising cost, security, and reliability across EC2, ECS, S3, Lambda, CloudWatch, IAM, Redshift, and ElastiCache.',
        highlights: ['EC2 & ECS container orchestration', 'S3 storage with lifecycle policies', 'Lambda serverless functions', 'CloudWatch monitoring & alerting', 'Cost optimisation & reserved capacity'],
    },
    {
        name: 'Amazon Connect',
        sub: 'Streams API · CX',
        img: '/images/brands/amazon-connect.png',
        detail: 'Built deep Amazon Connect integrations including a custom CCP, real-time call analytics via Lambda, and contact flow architecture powering a HIPAA-compliant patient contact system.',
        highlights: ['Custom CCP with Amazon Connect Streams', 'Real-time call analytics via Lambda', 'Contact flow design & management', 'Agent event processing & reporting', 'HIPAA-compliant call routing'],
    },
    {
        name: 'Terraform',
        sub: 'IaC',
        img: '/images/brands/terraform.svg',
        detail: 'Infrastructure as Code for AWS environments. Manages reproducible, version-controlled infrastructure definitions that maintain environment parity across dev, staging, and production.',
        highlights: ['AWS resource provisioning', 'Module-based reusable infrastructure', 'Environment parity (dev/staging/prod)', 'Remote state management', 'IAM policy & role automation'],
    },
    {
        name: 'Docker',
        sub: 'Containers',
        kind: 'docker',
        detail: 'Containerises development environments and production workloads. Standardised local dev setups across teams and manages ECS task definitions for container deployments on AWS.',
        highlights: ['Standardised local dev environments', 'ECS task definition management', 'Docker Compose for local stacks', 'Multi-stage build optimisation', 'Container security hardening'],
    },
    {
        name: 'GitHub Actions',
        sub: 'CI/CD · Automation',
        kind: 'githubactions',
        detail: 'CI/CD pipelines for automated testing, SAST security scanning, Docker builds, and deployment workflows. Enables consistent, gated releases across all environments.',
        highlights: ['Automated test & lint pipelines', 'SAST & dependency scanning', 'Docker build & push to ECR', 'Environment-based deployment gates', 'Slack notification integrations'],
    },
    // ── AI / ML ───────────────────────────────────────────────────
    {
        name: 'Neuron AI',
        sub: 'RAG · Embeddings',
        kind: 'neuronai',
        detail: 'Integrated NeuronAI to build a RAG-based knowledge base assistant. Manages vector embeddings, document parsing, and contextual AI responses grounded in uploaded knowledge documents.',
        highlights: ['RAG pipeline with vector embeddings', 'Ollama + OpenAI provider support', 'Document ingestion & chunking', 'Context-aware AI responses', 'Custom ChatAssistant implementation'],
    },
    {
        name: 'Ollama',
        sub: 'Local LLMs',
        kind: 'ollama',
        detail: 'Runs local LLMs for privacy-first AI features without sending data to third-party APIs. Evaluated for on-premise healthcare AI use cases where PHI data cannot leave the network.',
        highlights: ['Local LLM inference (no cloud API)', 'Privacy-first AI for healthcare data', 'Multiple model support (Llama, Mistral)', 'NeuronAI framework integration', 'On-premise deployment ready'],
    },
    // ── Databases & Infrastructure ────────────────────────────────
    {
        name: 'MySQL',
        sub: 'Relational DB',
        kind: 'mysql',
        detail: 'Primary OLTP database across most projects. Focus on schema design, complex query optimisation, indexing strategies, and Eloquent ORM integration for maintainable data layers.',
        highlights: ['Complex query optimisation & indexing', 'Eloquent ORM with eager loading', 'Database migrations & rollbacks', 'Multi-tenant schema design', 'Replication & backup strategies'],
    },
    {
        name: 'PostgreSQL',
        sub: 'Advanced RDBMS',
        kind: 'postgresql',
        detail: 'Used for advanced relational workloads requiring JSONB columns, full-text search, and window functions. Chosen when MySQL\'s feature set is insufficient for analytical queries.',
        highlights: ['JSONB columns for flexible schemas', 'Full-text search capabilities', 'Window functions & CTEs', 'Advanced constraint patterns', 'Connection pooling strategies'],
    },
    {
        name: 'Redis',
        sub: 'Cache · ElastiCache',
        kind: 'redis',
        detail: 'Used for session caching, queue backends, and real-time data storage with Laravel\'s cache and queue drivers. Managed as AWS ElastiCache for scalable, managed Redis clusters.',
        highlights: ['Laravel cache & session driver', 'Queue backend for job processing', 'AWS ElastiCache provisioning', 'Cache invalidation strategies', 'Real-time pub/sub patterns'],
    },
    {
        name: 'Redshift',
        sub: 'Data Warehouse',
        kind: 'redshift',
        detail: 'AWS Redshift used for analytics and reporting at scale. Analysed call centre performance metrics and operational KPIs by building ETL pipelines from production RDS into Redshift.',
        highlights: ['Call centre analytics & KPI reporting', 'ETL pipelines from RDS → Redshift', 'Columnar storage optimisation', 'Complex aggregation queries', 'BI dashboard data sourcing'],
    },
    {
        name: 'Nginx',
        sub: 'Web Server · Proxy',
        kind: 'nginx',
        detail: 'Configured as reverse proxy, load balancer, and static file server for Laravel applications. Handles SSL termination, request routing, and rate limiting at the infrastructure edge.',
        highlights: ['Reverse proxy for Laravel apps', 'SSL/TLS termination', 'Static file caching & gzip', 'Rate limiting & request filtering', 'WebSocket proxy configuration'],
    },
    // ── Security & Compliance ─────────────────────────────────────
    {
        name: 'HIPAA',
        sub: 'Healthcare Privacy',
        compliance: true,
        detail: 'Maintained HIPAA compliance across healthcare applications at Pleio. Responsible for PHI data handling controls, access logging, encryption standards, and breach risk procedures.',
        highlights: ['PHI data handling & encryption at rest', 'Access logging & audit trails', 'Minimum necessary data principles', 'Business Associate Agreements (BAA)', 'Breach risk assessment processes'],
    },
    {
        name: 'HITRUST',
        sub: 'CSF Framework',
        compliance: true,
        detail: 'Applied HITRUST CSF controls for enterprise healthcare compliance. Contributed to certification evidence collection, security policy documentation, and continuous control monitoring.',
        highlights: ['CSF control implementation', 'Risk management framework', 'Security policy documentation', 'Third-party vendor assessment', 'Continuous compliance monitoring'],
    },
    {
        name: 'SOC 2',
        sub: 'Type II',
        compliance: true,
        detail: 'Supported SOC 2 Type II compliance by enforcing security controls, managing access policies, and contributing to the evidence collection process for trust service criteria.',
        highlights: ['Trust Service Criteria enforcement', 'Access control & change management', 'Encryption in transit & at rest', 'Incident response procedures', 'Continuous monitoring controls'],
    },
    {
        name: 'OWASP / SAST',
        sub: 'Application Security',
        kind: 'owasp',
        detail: 'Applied OWASP Top 10 mitigations during code reviews and automated SAST scanning integrated into CI/CD pipelines. Proactively identifies vulnerabilities before they reach production.',
        highlights: ['OWASP Top 10 mitigation patterns', 'SAST pipeline integration (CI/CD)', 'SQL injection & XSS prevention', 'Dependency vulnerability scanning', 'Secure code review practices'],
    },
    {
        name: 'AWS IAM',
        sub: 'Identity & Access',
        kind: 'iam',
        detail: 'Designed least-privilege IAM policies across AWS environments. Manages roles, policies, and service-to-service permissions ensuring minimal attack surface across all cloud resources.',
        highlights: ['Least-privilege policy design', 'Role-based access for ECS & Lambda', 'Cross-account trust policies', 'MFA enforcement for IAM users', 'Service Control Policies (SCP)'],
    },
    // ── Tools & Methods ───────────────────────────────────────────
    {
        name: 'Git',
        sub: 'Version Control',
        kind: 'git',
        detail: 'Uses Git for all version control with conventional commits, feature branching, and PR-based workflows. Enforces quality gates via pre-commit hooks in team environments.',
        highlights: ['Feature branch & GitFlow workflows', 'Conventional commit standards', 'Interactive rebase & cherry-pick', 'Code review via Pull Requests', 'Git hooks for quality gates'],
    },
    {
        name: 'PHPUnit',
        sub: 'Testing Framework',
        kind: 'phpunit',
        detail: 'Writes unit and feature tests for Laravel applications. Focus on meaningful test coverage for critical business logic, database interactions, and API endpoints.',
        highlights: ['Unit & feature test suites', 'Mock & stub patterns', 'Database factory testing', 'API endpoint test coverage', 'Test-driven bug fixing'],
    },
    {
        name: 'Agile / Scrum',
        sub: 'Methodology',
        kind: 'agile',
        detail: 'Led sprint planning and retrospectives at Pleio while managing an offshore development team. Translates business requirements into clear sprint goals with measurable acceptance criteria.',
        highlights: ['Sprint planning & retrospectives', 'Offshore team leadership', 'Stakeholder expectation management', 'Backlog refinement & estimation', 'Velocity tracking & forecasting'],
    },
    // ── AWS Services ─────────────────────────────────────────────
    {
        name: 'AWS CodePipeline',
        sub: 'CI/CD Pipeline',
        img: '/images/brands/aws-codepipeline.png',
        detail: 'Automated multi-stage CI/CD pipelines on AWS integrating source, build, test, and deploy stages. Powers fully automated release workflows from GitHub commit to production ECS deployment.',
        highlights: ['Multi-stage pipeline configuration', 'Source → Build → Deploy automation', 'Integration with CodeBuild & ECR', 'Environment approval gates', 'Rollback triggers on failure'],
    },
    {
        name: 'AWS CodeBuild',
        sub: 'Build Service',
        kind: 'codebuild',
        detail: 'Fully managed build service running test suites, Docker image builds, and deployment packages inside AWS. Integrated with CodePipeline for automated build triggers.',
        highlights: ['Docker image builds & ECR push', 'Automated test execution', 'Buildspec YAML configuration', 'Environment variable management', 'Build artifact generation'],
    },
    {
        name: 'AWS S3',
        sub: 'Object Storage',
        kind: 's3',
        detail: 'Object storage used for static assets, file uploads, deployment artifacts, and data lake staging. Configured with lifecycle policies, versioning, and fine-grained IAM bucket policies.',
        highlights: ['Static asset hosting & CDN origin', 'Lifecycle policy configuration', 'Versioning & cross-region replication', 'Signed URL generation', 'Terraform-managed bucket policies'],
    },
    {
        name: 'AWS ECR',
        sub: 'Container Registry',
        kind: 'ecr',
        detail: 'Private container registry storing Docker images for ECS deployments. Integrated into CI/CD pipelines via GitHub Actions and CodePipeline for automated image builds and pushes.',
        highlights: ['Private Docker image hosting', 'Automated push from CI/CD pipelines', 'Image scanning for vulnerabilities', 'Lifecycle policy for image cleanup', 'Cross-account repository access'],
    },
    {
        name: 'AWS EC2',
        sub: 'Compute',
        kind: 'ec2',
        detail: 'Provisioned and managed EC2 instances for application servers, bastion hosts, and worker processes. Configured auto-scaling groups, load balancers, and security groups for production reliability.',
        highlights: ['Auto-scaling group configuration', 'Launch template management', 'Security group hardening', 'EBS volume & snapshot management', 'Reserved instance cost optimisation'],
    },
    {
        name: 'AWS Route 53',
        sub: 'DNS · Routing',
        kind: 'route53',
        detail: 'Managed DNS routing for applications including health-check-based failover, weighted routing for blue/green deployments, and private hosted zones for internal services.',
        highlights: ['Health-check failover routing', 'Weighted routing for deployments', 'Private hosted zones for internal DNS', 'SSL certificate validation via DNS', 'Alias records for ELB & CloudFront'],
    },
    {
        name: 'AWS Lambda',
        sub: 'Serverless Functions',
        kind: 'lambda',
        detail: 'Built serverless functions for real-time phone analytics, event-driven automation, and scheduled jobs. Leveraged Lambda as the processing backbone for the Amazon Connect call analytics pipeline.',
        highlights: ['Real-time call analytics processing', 'Event-driven triggers (S3, SQS, API Gateway)', 'Amazon Connect Streams integration', 'Python & Node.js runtimes', 'Cold start optimisation'],
    },
    {
        name: 'AWS WorkSpaces',
        sub: 'Virtual Desktop',
        kind: 'workspaces',
        detail: 'Administered AWS WorkSpaces virtual desktops for secure remote access in HIPAA-compliant environments, ensuring PHI data never leaves the AWS network.',
        highlights: ['HIPAA-compliant remote desktop', 'Active Directory integration', 'Bundle & image management', 'Access control policies', 'Cost-optimised billing modes'],
    },
    {
        name: 'Connect Flows',
        sub: 'IVR · Contact Flows',
        kind: 'connectflows',
        detail: 'Designed and maintained Amazon Connect contact flows powering patient call routing, IVR menus, queue management, and agent whisper flows in a HIPAA-compliant call centre environment.',
        highlights: ['IVR menu & call routing design', 'Queue transfer & whisper flows', 'Lambda integration within flows', 'Dynamic contact attributes', 'HIPAA-compliant call handling'],
    },
    {
        name: 'Ubuntu',
        sub: 'Linux OS',
        kind: 'ubuntu',
        detail: 'Primary Linux distribution for server environments, Docker base images, and local development. Comfortable with package management, systemd services, file permissions, and server hardening.',
        highlights: ['Server provisioning & hardening', 'systemd service management', 'Package management (apt/snap)', 'Docker base image configuration', 'SSH & firewall (ufw) configuration'],
    },
    {
        name: 'Bash / Shell',
        sub: 'Scripting',
        kind: 'bash',
        detail: 'Writes production shell scripts for deployment automation, server provisioning, cron jobs, and data processing pipelines. Comfortable with advanced bash patterns, stream processing, and CLI tool composition.',
        highlights: ['Deployment automation scripts', 'Data processing with awk/sed/jq', 'Cron job scheduling', 'Environment variable management', 'CI/CD pipeline shell steps'],
    },
    {
        name: 'Twilio',
        sub: 'Communications API',
        kind: 'twilio',
        detail: 'Integrated Twilio\'s Programmable Voice and SMS APIs for communications features. Experience with TwiML, webhook configuration, and building softphone-adjacent call handling logic.',
        highlights: ['Programmable Voice & SMS APIs', 'TwiML response generation', 'Webhook endpoint configuration', 'Call recording & transcription', 'Fallback & error handling'],
    },
    {
        name: 'Python',
        sub: 'Scripting · Automation',
        kind: 'python',
        detail: 'Used Python for AWS Lambda functions, data processing scripts, ETL pipelines, and infrastructure automation via boto3. Focus on clean, maintainable scripts for operational and data engineering tasks.',
        highlights: ['AWS Lambda (boto3 SDK)', 'Data processing & ETL pipelines', 'Large dataset migration scripts', 'CLI automation tooling', 'S3 / Redshift data workflows'],
    },
];

const pages = computed(() => {
    const result: TechItem[][] = [];
    for (let i = 0; i < stack.length; i += ITEMS_PER_PAGE) {
        result.push(stack.slice(i, i + ITEMS_PER_PAGE));
    }
    return result;
});

const totalPages = computed(() => pages.value.length);
const currentItems = computed(() => pages.value[currentPage.value] ?? []);
const prev = () => { if (currentPage.value > 0) currentPage.value--; };
const next = () => { if (currentPage.value < totalPages.value - 1) currentPage.value++; };
</script>

<template>
    <div class="flex flex-col items-center gap-6 w-full">
        <div class="grid w-full grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5">
            <div
                v-for="item in currentItems"
                :key="item.name"
                class="flex cursor-pointer flex-col items-center gap-3 rounded-xl border border-[#e3e3e0] bg-white p-5 transition-all hover:-translate-y-1 hover:border-[#c9c9c6] hover:shadow-md dark:border-[#2a2a28] dark:bg-[#161615] dark:hover:border-[#3E3E3A]"
                @click="openTech(item)"
            >
                <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-xl bg-[#f4f4f2] dark:bg-[#1f1f1f]">
                    <TechLogo :kind="item.kind" :img="item.img" :compliance="item.compliance" :name="item.name" />
                </div>
                <span class="text-center text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ item.name }}</span>
                <span v-if="item.sub" class="text-center text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ item.sub }}</span>
            </div>
        </div>

        <!-- Pagination nav -->
        <div class="flex items-center gap-4">
            <button
                @click="prev"
                :disabled="currentPage === 0"
                class="flex h-8 w-8 items-center justify-center rounded-full border border-[#e3e3e0] bg-white text-[#706f6c] transition-colors hover:border-[#c9c9c6] hover:text-[#1b1b18] disabled:cursor-not-allowed disabled:opacity-30 dark:border-[#2a2a28] dark:bg-[#161615] dark:text-[#A1A09A] dark:hover:border-[#3E3E3A] dark:hover:text-[#EDEDEC]"
            >
                <ChevronLeft class="h-4 w-4" />
            </button>

            <div class="flex gap-2">
                <button
                    v-for="i in totalPages"
                    :key="i"
                    @click="currentPage = i - 1"
                    :class="i - 1 === currentPage
                        ? 'w-5 bg-[#1b1b18] dark:bg-[#EDEDEC]'
                        : 'w-2 bg-[#e3e3e0] dark:bg-[#2a2a28] hover:bg-[#c9c9c6] dark:hover:bg-[#3E3E3A]'"
                    class="h-2 rounded-full transition-all"
                />
            </div>

            <button
                @click="next"
                :disabled="currentPage === totalPages - 1"
                class="flex h-8 w-8 items-center justify-center rounded-full border border-[#e3e3e0] bg-white text-[#706f6c] transition-colors hover:border-[#c9c9c6] hover:text-[#1b1b18] disabled:cursor-not-allowed disabled:opacity-30 dark:border-[#2a2a28] dark:bg-[#161615] dark:text-[#A1A09A] dark:hover:border-[#3E3E3A] dark:hover:text-[#EDEDEC]"
            >
                <ChevronRight class="h-4 w-4" />
            </button>
        </div>
    </div>

    <!-- Tech detail dialog -->
    <Dialog v-model:open="dialogOpen">
        <DialogContent class="max-w-md">
            <DialogHeader>
                <div class="mb-4 flex items-center gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#f4f4f2] dark:bg-[#1f1f1f]">
                        <TechLogo
                            :kind="selectedTech?.kind"
                            :img="selectedTech?.img"
                            :compliance="selectedTech?.compliance"
                            :name="selectedTech?.name"
                        />
                    </div>
                    <div>
                        <DialogTitle class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ selectedTech?.name }}
                        </DialogTitle>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ selectedTech?.sub }}</p>
                    </div>
                </div>
                <DialogDescription class="text-left text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                    {{ selectedTech?.detail }}
                </DialogDescription>
            </DialogHeader>

            <div class="mt-2 flex flex-wrap gap-2">
                <span
                    v-for="h in selectedTech?.highlights"
                    :key="h"
                    class="rounded-full bg-[#f4f4f2] px-3 py-1 text-xs font-medium text-[#1b1b18] dark:bg-[#1f1f1f] dark:text-[#EDEDEC]"
                >
                    {{ h }}
                </span>
            </div>
        </DialogContent>
    </Dialog>
</template>
