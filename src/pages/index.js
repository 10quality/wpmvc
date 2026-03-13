import clsx from 'clsx';
import Link from '@docusaurus/Link';
import useDocusaurusContext from '@docusaurus/useDocusaurusContext';
import Layout from '@theme/Layout';
import Head from '@docusaurus/Head';
import HomepageFeatures from '@site/src/components/HomepageFeatures';
import HomepageCreateProject from '@site/src/components/HomepageCreateProject';
import useBaseUrl from '@docusaurus/useBaseUrl';

import Heading from '@theme/Heading';
import styles from './index.module.css';

function HomepageHeader() {
  const {siteConfig} = useDocusaurusContext();
  return (
    <header className={clsx('hero hero--primary', styles.heroBanner)}>
      <div className="container">
        <img className={styles.logo} src={useBaseUrl('/img/wpmvc-icon-blue.png')} alt="WordPress MVC logo"/>
        <Heading as="h1" className="hero__title">
          {siteConfig.title}
        </Heading>
        <p className="hero__subtitle">{siteConfig.tagline}</p>
        <div className={styles.buttons}>
          <Link
            className="button button--secondary button--lg"
            to="/docs/intro">
            Get Started
          </Link>
        </div>
      </div>
    </header>
  );
}

// <!-- <HomepageFeatures /> -->
export default function Home() {
  const {siteConfig} = useDocusaurusContext();
  return (
    <Layout
      title="Welcome"
      description="WordPress MVC is a powerful framework that brings the Model-View-Controller (MVC) architecture to WordPress development. It provides a structured and organized way to build custom themes and plugins, making it easier for developers to create maintainable and scalable WordPress applications.">
      <HomepageHeader />
      <main>
        <HomepageCreateProject bgUrl={useBaseUrl('/img/wpmvc-icon-blue.png')}/>
        <HomepageFeatures bgUrl={useBaseUrl('/img/wpmvc-icon-blue.png')}/>
      </main>
    </Layout>
  );
}
